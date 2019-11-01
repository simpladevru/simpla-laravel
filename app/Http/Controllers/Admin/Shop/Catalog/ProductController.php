<?php

namespace App\Http\Controllers\Admin\Shop\Catalog;

use Throwable;
use Exception;
use DomainException;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Entity\Shop\Product\Product;
use App\Entity\Shop\Product\Variant;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\UseCase\Admin\ProductService;
use App\UseCase\Admin\VariantService;
use App\Repositories\Shop\Catalog\BrandRepository;
use App\Repositories\Shop\Catalog\FeatureRepository;
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
     * ProductController constructor.
     *
     * @param ProductService $service
     * @param BrandRepository $brandRepository
     * @param CategoryRepository $categoryRepository
     * @param FeatureRepository $featureRepository
     * @param VariantService $variantService
     */
    public function __construct(
        ProductService $service,
        BrandRepository $brandRepository,
        CategoryRepository $categoryRepository,
        FeatureRepository $featureRepository,
        VariantService $variantService
    ) {
        $this->service            = $service;
        $this->featureRepository  = $featureRepository;
        $this->variantService     = $variantService;
        $this->brandRepository    = $brandRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $query = Product::with(['variants', 'image'])
            ->orderByDesc('id');

        $products = $query->paginate(20);

        return view(static::VIEW_PATH . 'index', [
            'products' => $products,
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
        $features = $this->featureRepository->getByCategoryId(1);
        $variants = [new Variant()];

        return view(static::VIEW_PATH . 'form', [
            'product'  => new Product(),
            'variants' => $variants,
            'features' => $features,
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

        return redirect()->route(static::ROUTE_PATH . 'edit', $product)->with('success', 'added');
    }

    /**
     * @param Product $product
     * @return View
     * @throws Exception
     */
    public function edit(Product $product): View
    {
        $features      = $this->featureRepository->getByCategoryId(1);
        $brands        = $this->brandRepository->getAll();
        $categories    = $this->categoryRepository->getAllWithDepth();
        $categoriesIds = $product->categories()->allRelatedIds()->toArray();

        return view(static::VIEW_PATH . 'form', [
            'product'       => $product,
            'brands'        => $brands,
            'categories'    => $categories,
            'categoriesIds' => $categoriesIds,
            'features'      => $features,
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

        return back()->with('success', 'updated');
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
