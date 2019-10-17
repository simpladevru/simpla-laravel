<?php

namespace App\Http\Controllers\Admin\Shop\Catalog;

use Exception;
use DomainException;
use Illuminate\View\View;
use App\Entity\Shop\Feature;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\UseCase\Shop\Catalog\FeatureService;
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
     * FeatureController constructor.
     *
     * @param FeatureService $service
     */
    public function __construct(FeatureService $service)
    {
        $this->service = $service;
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
        return view(static::VIEW_PATH . 'form', [
            'feature' => new Feature(),
        ]);
    }

    /**
     * @param FeatureRequest $request
     * @return RedirectResponse
     */
    public function store(FeatureRequest $request): RedirectResponse
    {
        try {
            $feature = $this->service->create($request->toArray());
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
        return view(static::VIEW_PATH . 'form', [
            'feature' => $feature,
        ]);
    }

    /**
     * @param FeatureRequest $request
     * @param Feature $feature
     * @return RedirectResponse
     */
    public function update(FeatureRequest $request, Feature $feature): RedirectResponse
    {
        try {
            $this->service->edit($feature->id, $request->toArray());
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
