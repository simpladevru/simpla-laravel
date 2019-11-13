<?php

namespace App\Http\Controllers\Admin\Shop\Catalog;

use Exception;
use Throwable;
use DomainException;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Entity\Shop\Catalog\Feature\Feature;
use Illuminate\Http\RedirectResponse;
use App\UseCase\Shop\Catalog\Feature\FeatureService;
use App\Repositories\Shop\Catalog\FeatureRepository;
use App\Repositories\Shop\Catalog\CategoryRepository;
use App\Http\Requests\Admin\Shop\Catalog\FeatureRequest;

class FeatureController extends Controller
{
    const ROUTE_PATH = 'admin.shop.catalog.features.';
    const VIEW_PATH  = 'shop.catalog.features.';

    /**
     * @var FeatureService
     */
    private $service;

    /**
     * @var CategoryRepository
     */
    private $categories;

    /**
     * @var FeatureRepository
     */
    private $features;

    /**
     * FeatureController constructor.
     *
     * @param FeatureService $service
     * @param CategoryRepository $categories
     * @param FeatureRepository $features
     */
    public function __construct(
        FeatureService $service,
        CategoryRepository $categories,
        FeatureRepository $features
    ) {
        $this->service    = $service;
        $this->categories = $categories;
        $this->features   = $features;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = $this->features->query();

        if ($keyword = $request->get('keyword')) {
            $query = $query->whereNameLike($keyword);
        }

        if ($categoryId = $request->get('category_id')) {
            $query->whereJoinedCategory((array) $categoryId);
        }

        $query->orderBy('id');

        $categories = $this->categories->getAllWithDepth();

        return view(static::VIEW_PATH . 'index', [
            'features'   => $query->paginate(20),
            'categories' => $categories,
        ]);
    }

    /**
     * @param Feature $feature
     * @return Response
     */
    public function show(Feature $feature): Response
    {
        //
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $categories = $this->categories->getAllWithDepth();

        return view(static::VIEW_PATH . 'form', [
            'feature'       => new Feature(),
            'categories'    => $categories,
            'categoriesIds' => [],
        ]);
    }

    /**
     * @param FeatureRequest $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(FeatureRequest $request): RedirectResponse
    {
        try {
            $feature = $this->service->createWithRelations($request->validated());
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        $response = !empty($request['submit-apply'])
            ? redirect()->route(static::ROUTE_PATH . 'edit', $feature)
            : redirect()->route(static::ROUTE_PATH . 'index');

        return $response->with('success', 'added');
    }

    /**
     * @param Feature $feature
     * @return View
     */
    public function edit(Feature $feature): View
    {
        $categories    = $this->categories->getAllWithDepth();
        $categoriesIds = $feature->categories()->allRelatedIds()->toArray();

        return view(static::VIEW_PATH . 'form', [
            'feature'       => $feature,
            'categories'    => $categories,
            'categoriesIds' => $categoriesIds,
        ]);
    }

    /**
     * @param FeatureRequest $request
     * @param Feature $feature
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(FeatureRequest $request, Feature $feature): RedirectResponse
    {
        try {
            $this->service->updateWithRelations($feature->id, $request->validated());
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        $response = !empty($request['submit-apply'])
            ? redirect()->route(static::ROUTE_PATH . 'edit', $feature)
            : redirect()->route(static::ROUTE_PATH . 'index');

        return $response->with('success', 'updated');
    }

    /**
     * @param Feature $feature
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Feature $feature): RedirectResponse
    {
        try {
            $this->service->remove($feature->id);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'deleted');
    }
}
