<?php

namespace App\Http\Controllers\Admin\Shop\Catalog;

use Exception;
use DomainException;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Entity\Shop\Catalog\Category\Category;
use App\Repositories\Shop\Catalog\CategoryRepository;
use App\UseCase\Shop\Catalog\Category\CategoryService;
use App\Http\Requests\Admin\Shop\Catalog\CategoryRequest;

class CategoryController extends Controller
{
    const ROUTE_PATH = 'admin.shop.catalog.categories.';
    const VIEW_PATH  = 'shop.catalog.categories.';

    /**
     * @var CategoryService
     */
    private $service;

    /**
     * @var CategoryRepository
     */
    private $categories;

    /**
     * CategoryController constructor.
     *
     * @param CategoryService $service
     * @param CategoryRepository $categories
     */
    public function __construct(CategoryService $service, CategoryRepository $categories)
    {
        $this->service    = $service;
        $this->categories = $categories;
    }

    /**
     * @param Category|null $category
     * @return View
     */
    public function index(Category $category = null): View
    {
        $filter = request()->all([
            'keyword',
        ]);

        $query = $this->categories->query()->withCount(['descendants', 'productsPivot', 'productsPivotNested']);

        if ($category) {
            $query->whereParentId($category->id);
        } elseif ($filter['keyword']) {
            $query = $query->whereNameLike($filter['keyword'])->with('ancestors');
        } else {
            $query->whereIsRoot();
        }

        $categories = $query->defaultOrder()->paginate(20);

        return view(static::VIEW_PATH . 'index', [
            'category'   => $category,
            'categories' => $categories,
        ]);
    }

    /**
     * @param Category $category
     * @return Response
     */
    public function show(Category $category): Response
    {
        //
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $categories = Category::defaultOrder()->withDepth()->get();

        return view(static::VIEW_PATH . 'form', [
            'category'   => new Category(),
            'categories' => $categories,
        ]);
    }

    /**
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        try {
            $category = $this->service->create($request->validated());
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        $response = !empty($request['submit-apply'])
            ? redirect()->route(static::ROUTE_PATH . 'edit', $category)
            : redirect()->route(static::ROUTE_PATH . 'index');

        return $response->with('success', 'added');
    }

    /**
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        $categories = Category::defaultOrder()->withDepth()->get();

        return view(static::VIEW_PATH . 'form', [
            'category'   => $category,
            'categories' => $categories,
        ]);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        try {
            $this->service->update($category->id, $request->validated());
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        $response = !empty($request['submit-apply'])
            ? redirect()->route(static::ROUTE_PATH . 'edit', $category)
            : redirect()->route(static::ROUTE_PATH . 'index');

        return $response->with('success', 'updated');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            $this->service->remove($category->id);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'deleted');
    }

    /**
     * @return array
     */
    public function ajaxAllWithDepth(): array
    {
        return $this->categories->getAllWithDepth(['id', 'name'])->toArray();
    }

    /**
     * @param Category $category
     * @return array
     */
    public function ajaxFeatures(Category $category)
    {
        return array_map(function ($feature) {
            return Arr::only($feature, ['id', 'name']);
        }, $category->features()->get(['id', 'name'])->toArray());
    }
}
