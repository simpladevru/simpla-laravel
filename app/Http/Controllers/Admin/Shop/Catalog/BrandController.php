<?php

namespace App\Http\Controllers\Admin\Shop\Catalog;

use Exception;
use DomainException;
use Illuminate\View\View;
use Illuminate\Http\Response;
use App\Entity\Shop\Catalog\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\UseCase\Admin\BrandService;
use App\Repositories\Shop\Catalog\BrandRepository;
use App\Http\Requests\Admin\Shop\Catalog\BrandRequest;

class BrandController extends Controller
{
    const ROUTE_PATH = 'admin.shop.catalog.brands.';
    const VIEW_PATH  = 'shop.catalog.brands.';

    /**
     * @var BrandService
     */
    private $service;
    /**
     * @var BrandRepository
     */
    private $repository;

    /**
     * BrandController constructor.
     *
     * @param BrandService $service
     * @param BrandRepository $repository
     */
    public function __construct(BrandService $service, BrandRepository $repository)
    {
        $this->service    = $service;
        $this->repository = $repository;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $brands = $this->repository->query()
            ->withCount('products')
            ->orderByDesc('name')
            ->paginate(20);

        return view(static::VIEW_PATH . 'index', [
            'brands' => $brands,
        ]);
    }

    /**
     * @param Brand $brand
     * @return Response
     */
    public function show(Brand $brand): Response
    {
        //
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view(static::VIEW_PATH . 'form', [
            'brand' => new Brand(),
        ]);
    }

    /**
     * @param BrandRequest $request
     * @return RedirectResponse
     */
    public function store(BrandRequest $request): RedirectResponse
    {
        try {
            $brand = $this->service->create($request->validated());
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        $response = !empty($request['submit-apply'])
            ? redirect()->route(static::ROUTE_PATH . 'edit', $brand)
            : redirect()->route(static::ROUTE_PATH . 'index');

        return $response->with('success', 'added');
    }

    /**
     * @param Brand $brand
     * @return View
     */
    public function edit(Brand $brand): View
    {
        return view(static::VIEW_PATH . 'form', [
            'brand' => $brand,
        ]);
    }

    /**
     * @param BrandRequest $request
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function update(BrandRequest $request, Brand $brand): RedirectResponse
    {
        try {
            $this->service->update($brand->id, $request->validated());
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        $response = !empty($request['submit-apply'])
            ? redirect()->route(static::ROUTE_PATH . 'edit', $brand)
            : redirect()->route(static::ROUTE_PATH . 'index');

        return $response->with('success', 'updated');
    }

    /**
     * @param Brand $brand
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        try {
            $this->service->remove($brand->id);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'deleted');
    }
}
