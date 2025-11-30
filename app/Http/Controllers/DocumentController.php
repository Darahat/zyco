<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = DB::table('users_documents')
            ->where('user_id', Auth::id())
            ->get();
        
        return view('backend.document.index', compact('documents'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $data['user_id'] = Auth::id();
            
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documents', $filename, 'public');
                $data['document_path'] = $path;
            }
            
            DB::table('users_documents')->insert($data);
            
            return redirect()->route('document')->with('success', 'Document added successfully');
        }
        
        return view('backend.document.add');
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documents', $filename, 'public');
                $data['document_path'] = $path;
            }
            
            DB::table('users_documents')->where('id', $id)->update($data);
            
            return redirect()->route('document')->with('success', 'Document updated successfully');
        }
        
        $document = DB::table('users_documents')->where('id', $id)->first();
        return view('backend.document.edit', compact('document'));
    }

    public function delete($id)
    {
        DB::table('users_documents')->where('id', $id)->delete();
        return redirect()->route('document')->with('success', 'Document deleted successfully');
    }
}
