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
use App\Repositories\Shop\Catalog\BrandRepository;
use App\UseCase\Shop\Catalog\Product\ProductService;
use App\UseCase\Shop\Catalog\Variant\VariantService;
use App\Repositories\Shop\Catalog\FeatureRepository;
use App\Entity\Shop\Catalog\Products\Product\Product;
use App\Repositories\Shop\Catalog\CategoryRepository;
use App\Repositories\Shop\Catalog\ProductRepository;
use App\Http\Requests\Admin\Shop\Catalog\Product\ProductRequest;
use App\Http\Requests\Admin\Shop\Catalog\Product\ProductGroupActionRequest;

class ProductController extends Controller
{
    const ROUTE_PATH = 'admin.shop.catalog.products.';
    const VIEW_PATH  = 'shop.catalog.products.';

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @var FeatureRepository
     */
    private $features;

    /**
     * @var VariantService
     */
    private $variantService;

    /**
     * @var BrandRepository
     */
    private $brands;

    /**
     * @var CategoryRepository
     */
    private $categories;

    /**
     * @var ProductRepository
     */
    private $products;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     * @param VariantService $variantService
     * @param BrandRepository $brands
     * @param CategoryRepository $categories
     * @param FeatureRepository $features
     * @param ProductRepository $products
     */
    public function __construct(
        ProductService $productService,
        VariantService $variantService,
        BrandRepository $brands,
        CategoryRepository $categories,
        FeatureRepository $features,
        ProductRepository $products
    ) {
        $this->productService = $productService;
        $this->variantService = $variantService;
        $this->features       = $features;
        $this->brands         = $brands;
        $this->categories     = $categories;
        $this->products       = $products;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = $this->products->query()->with(['brand', 'category', 'variants', 'image']);

        if ($brandIds = $request->get('brand_id')) {
            $query->whereBrandIds((array) $brandIds);
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

        $categories = $this->categories->getAllWithDepth();
        $brands     = $this->brands->getAll();

        return view(static::VIEW_PATH . 'index', [
            'products'   => $query->paginate(20),
            'categories' => $categories,
            'brands'     => $brands,
        ]);
    }

    /**
     * @param ProductGroupActionRequest $request
     * @return RedirectResponse
     */
    public function groupAction(ProductGroupActionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->variantService->updateList($validated['variants']);

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
        $brands = $this->brands->getAll();

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
            $product = $this->productService->createWithRelations($request->validated());
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
        $brands             = $this->brands->getAll();
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
            $this->productService->updateWithRelations($product->id, $request->validated());
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
            $this->productService->remove($product->id);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'deleted');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     * @throws Throwable
     */
    public function copy(Product $product): RedirectResponse
    {
        try {
            $this->productService->copy($product->id);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'copied');
    }
}
