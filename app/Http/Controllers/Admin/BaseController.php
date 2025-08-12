<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

abstract class BaseController extends Controller
{
    protected string $template = 'admin';
    protected string $module = '';
    protected array $data = [];

    public function redirectSuccess(
        string $route = 'admin.dashboard',
        string $message = ''
    ): RedirectResponse
    {
        return redirect()
            ->route($route)
            ->with([
                'success' => true,
                'message' => $message,
            ]);
    }

    public function redirectSuccessBack(
        string $message = ''
    ): RedirectResponse
    {
        return redirect()
            ->back()
            ->with([
                'success' => true,
                'message' => $message,
            ]);
    }

    public function redirectError(
        string $message = 'Unknown error'
    ): RedirectResponse
    {
        return redirect()
            ->back()
            ->with([
                'success' => false,
                'message' => $message,
            ]);
    }

    public function json($code = 200): JsonResponse
    {
        return response()->json($this->data, $code);
    }

    public function render($view = null)
    {
        if (request()->expectsJson() || is_null($view)) {
            return $this->json($this->data);
        }

        return view($this->template . '/modules/' . $this->module . '/' . $view, $this->data);
    }
}
