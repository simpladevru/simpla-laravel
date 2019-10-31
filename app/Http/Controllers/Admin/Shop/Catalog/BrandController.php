<?php

namespace App\Http\Controllers\Admin\Shop\Catalog;

use Exception;
use DomainException;
use Illuminate\View\View;
use Illuminate\Http\Response;
use App\Entity\Shop\Catalog\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\UseCase\Shop\Catalog\BrandService;
use App\Http\Requests\Admin\Shop\Catalog\BrandRequest;
use ReflectionException;

class BrandController extends Controller
{
    const ROUTE_PATH = 'admin.shop.catalog.brands.';
    const VIEW_PATH  = 'shop.catalog.brands.';

    /**
     * @var BrandService
     */
    private $service;

    /**
     * BrandController constructor.
     *
     * @param BrandService $service
     */
    public function __construct(BrandService $service)
    {
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $query  = Brand::orderByDesc('id');
        $brands = $query->paginate(20);

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
     * @throws ReflectionException
     */
    public function store(BrandRequest $request): RedirectResponse
    {
        try {
            $brand = $this->service->create($request);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route(static::ROUTE_PATH . 'edit', $brand)->with('success', 'added');
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
     * @throws ReflectionException
     */
    public function update(BrandRequest $request, Brand $brand): RedirectResponse
    {
        try {
            $this->service->edit($brand->id, $request);
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'updated');
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
