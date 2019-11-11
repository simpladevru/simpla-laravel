<?php

namespace App\Http\Controllers\Admin\Shop\Catalog;

use Throwable;
use Exception;
use DomainException;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\UseCase\Shop\Catalog\Product\ProductService;
use App\UseCase\Shop\Catalog\Variant\VariantService;
use App\Repositories\Shop\Catalog\BrandRepository;
use App\Repositories\Shop\Catalog\FeatureRepository;
use App\Repositories\Shop\Catalog\ProductRepository;
use App\Entity\Shop\Catalog\Products\Product\Product;
use App\Repositories\Shop\Catalog\CategoryRepository;
use App\Http\Requests\Admin\Shop\Catalog\ProductRequest;

class ProductController extends Controller
{
    const ROUTE_PATH = 'admin.shop.catalog.products.';
    const VIEW_PATH  = 'shop.catalog.products.';

    /**
     * @var ProductService
     */
    private $service;

    /**
     * @var FeatureRepository
     */
    private $featureRepository;

    /**
     * @var VariantService
     */
    private $variantService;

    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * ProductController constructor.
     *
     * @param ProductService $service
     * @param BrandRepository $brandRepository
     * @param CategoryRepository $categoryRepository
     * @param FeatureRepository $featureRepository
     * @param VariantService $variantService
     * @param ProductRepository $productRepository
     */
    public function __construct(
        ProductService $service,
        BrandRepository $brandRepository,
        CategoryRepository $categoryRepository,
        FeatureRepository $featureRepository,
        VariantService $variantService,
        ProductRepository $productRepository
    ) {
        $this->service            = $service;
        $this->featureRepository  = $featureRepository;
        $this->variantService     = $variantService;
        $this->brandRepository    = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository  = $productRepository;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = $this->productRepository->query()->with(['brand', 'category', 'variants', 'image']);

        if ($brandIds = $request->get('brand_id')) {
            $query->whereBrandIds([$brandIds]);
        }

        if ($categoryId = $request->get('category_id')) {
            $query->whereJoinedCategory((array) $categoryId);
        }

        if ($categoryId = $request->get('category_nested_id')) {
            $query->whereJoinedCategoryNested([$categoryId]);
        }

        if ($keyword = $request->get('keyword')) {
            $query = $query->whereNameLike($keyword);
        }

        $query->orderByDesc('id');

        $categories = $this->categoryRepository->getAllWithDepth();
        $brands     = $this->brandRepository->getAll();

        return view(static::VIEW_PATH . 'index', [
            'products'   => $query->paginate(20),
            'categories' => $categories,
            'brands'     => $brands,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function groupAction(Request $request): RedirectResponse
    {
        $this->variantService->updateGroupedByPrimaryKey($request->get('variants'));

        return back()->with('success', 'updated');
    }

    /**
     * @param Product $product
     * @return Response
     */
    public function show(Product $product): Response
    {
        //
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $brands = $this->brandRepository->getAll();

        return view(static::VIEW_PATH . 'form', [
            'product'            => new Product(),
            'productCategoryIds' => [],
            'brands'             => $brands,
        ]);
    }

    /**
     * @param ProductRequest $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            $product = $this->service->createWithRelations($request->validated());
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        $response = !empty($request['submit-apply'])
            ? redirect()->route(static::ROUTE_PATH . 'edit', $product)
            : redirect()->route(static::ROUTE_PATH . 'index');

        return $response->with('success', 'added');
    }

    /**
     * @param Product $product
     * @return View
     * @throws Exception
     */
    public function edit(Product $product): View
    {
        $brands             = $this->brandRepository->getAll();
        $productCategoryIds = $product->categoryPivotIds();

        return view(static::VIEW_PATH . 'form', [
            'product'            => $product,
            'productCategoryIds' => $productCategoryIds,
            'brands'             => $brands,
        ]);
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        try {
            $this->service->updateWithRelations($product->id, $request->validated());
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        $response = !empty($request['submit-apply'])
            ? redirect()->route(static::ROUTE_PATH . 'edit', $product)
            : redirect()->route(static::ROUTE_PATH . 'index');

        return $response->with('success', 'updated');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            $this->service->remove($product->id);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'deleted');
    }
}
