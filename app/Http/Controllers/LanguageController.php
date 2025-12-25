<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    protected string $page_title = 'Admin Panel';

    /**
     * Language list
     */
    public function index()
    {
        $this->authorizeAdmin();

        Paginator::useBootstrap();

        $result = DB::table('language')->latest()->get();

        return view('backend.language.index', [
            'page_title'  => $this->page_title,
            'main_menu'   => 'informations',
            'page_header' => 'Language',
        ], compact('result'));
    }

    /**
     * Add language (GET + POST)
     */
    public function add(Request $request)
    {
        $this->authorizeAdmin();

        if ($request->isMethod('get')) {
            return view('backend.language.add', [
                'page_title'  => $this->page_title,
                'main_menu'   => 'informations',
                'page_header' => 'Add New Language',
            ]);
        }

        $request->validate([
            'name'   => 'required|unique:language,name',
            'value'  => 'required|unique:language,value',
            'status' => 'required|in:Active,Inactive',
        ]);

        DB::table('language')->insert([
            'name'   => $request->name,
            'value'  => $request->value,
            'status' => $request->status,
        ]);

        return redirect('admin/language')->with([
            'status' => 'Language saved successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Update language (GET + POST)
     */
    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        if ($request->isMethod('get')) {

            $result = DB::table('language')->find($id);

            abort_if(!$result, 404);

            return view('backend.language.edit', [
                'page_title'  => $this->page_title,
                'main_menu'   => 'informations',
                'page_header' => 'Update Language Information',
            ], compact('result'));
        }

        $request->validate([
            'name'   => 'required|unique:language,name,' . $id,
            'value'  => 'required|unique:language,value,' . $id,
            'status' => 'required|in:Active,Inactive',
        ]);

        DB::table('language')
            ->where('id', $id)
            ->update([
                'name'   => $request->name,
                'value'  => $request->value,
                'status' => $request->status,
            ]);

        return redirect('admin/language')->with([
            'status' => 'Language updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Delete language
     */
    public function delete($id)
    {
        $this->authorizeAdmin();

        $language = DB::table('language')->find($id);

        abort_if(!$language, 404);

        $isUsed = DB::table('users')
            ->where('language', $language->value)
            ->exists();

        if ($isUsed) {
            return redirect()->back()->with([
                'status' => 'This language is already assigned to users.',
                'alert-type' => 'error',
            ]);
        }

        DB::table('language')->where('id', $id)->delete();

        return redirect()->back()->with([
            'status' => 'Language deleted successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Admin guard helper
     */
    private function authorizeAdmin(): void
    {
        abort_if(!Auth::guard('admin')->check(), 403);
    }
}