<?php

namespace App\Http\Controllers\Admin\Shop\Catalog;

use Exception;
use DomainException;
use Illuminate\View\View;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Entity\Shop\Catalog\Category;
use App\UseCase\Shop\Catalog\CategoryService;
use App\Http\Requests\Admin\Shop\Catalog\CategoryRequest;

class CategoryController extends Controller
{
    const ROUTE_PATH = 'admin.shop.catalog.categories.';
    const VIEW_PATH  = 'admin.shop.catalog.categories.';

    /**
     * @var CategoryService
     */
    private $service;

    /**
     * CategoryController constructor.
     *
     * @param CategoryService $service
     */
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $query      = Category::orderByDesc('id');
        $categories = $query->paginate(20);

        return view(static::VIEW_PATH . 'index', [
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
        return view(static::VIEW_PATH . 'form', [
            'category' => new Category(),
        ]);
    }

    /**
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        try {
            $category = $this->service->create($request);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route(static::ROUTE_PATH . 'edit', $category)->with('success', 'added');
    }

    /**
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        return view(static::VIEW_PATH . 'form', [
            'category' => $category,
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
            $this->service->edit($category->id, $request);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'updated');
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
}
