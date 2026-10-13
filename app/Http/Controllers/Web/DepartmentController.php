<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('department_id', 'desc')
            ->paginate(10);

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => ['required', 'string', 'max:255'],
            'department_code' => [
                'required',
                'string',
                'max:50',
                'unique:departments,department_code',
            ],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'department_head' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:30'],
        ]);

        Department::create($validated);

        return redirect()
            ->route('web.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(string $id)
    {
        $department = Department::findOrFail($id);

        return view('departments.show', compact('department'));
    }

    public function edit(string $id)
    {
        $department = Department::findOrFail($id);

        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, string $id)
    {
        $department = Department::findOrFail($id);

        $validated = $request->validate([
            'department_name' => ['required', 'string', 'max:255'],
            'department_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('departments', 'department_code')
                    ->ignore($department->department_id, 'department_id'),
            ],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'department_head' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:30'],
        ]);

        $department->update($validated);

        return redirect()
            ->route('web.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);

        if ($department->employees()->exists()) {
            return redirect()
                ->route('web.departments.index')
                ->with('error', 'Cannot delete this department because employees are assigned to it.');
        }

        $department->delete();

        return redirect()
            ->route('web.departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}