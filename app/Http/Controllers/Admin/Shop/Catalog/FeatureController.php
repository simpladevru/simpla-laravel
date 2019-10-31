<?php

namespace App\Http\Controllers\Admin\Shop\Catalog;

use Exception;
use Throwable;
use DomainException;
use Illuminate\View\View;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Entity\Shop\Feature\Feature;
use Illuminate\Http\RedirectResponse;
use App\UseCase\Admin\FeatureService;
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
    private $categoryRepository;

    /**
     * FeatureController constructor.
     *
     * @param FeatureService $service
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(FeatureService $service, CategoryRepository $categoryRepository)
    {
        $this->service            = $service;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $query    = Feature::orderByDesc('id');
        $features = $query->paginate(20);

        return view(static::VIEW_PATH . 'index', [
            'features' => $features,
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
        $categories = $this->categoryRepository->getAllWithDepth();

        return view(static::VIEW_PATH . 'form', [
            'feature'    => new Feature(),
            'categories' => $categories,
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

        return redirect()->route(static::ROUTE_PATH . 'edit', $feature)->with('success', 'added');
    }

    /**
     * @param Feature $feature
     * @return View
     */
    public function edit(Feature $feature): View
    {
        $categories    = $this->categoryRepository->getAllWithDepth();
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

        return back()->with('success', 'updated');
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
