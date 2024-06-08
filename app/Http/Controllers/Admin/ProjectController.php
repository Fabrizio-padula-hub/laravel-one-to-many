<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        
        $data = [
            'projects'=>$projects
        ];

        return view('admin.projects.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();

        $data = [
            'types'=>$types
        ];

        return view('admin.projects.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|min:5|max:200',
                'client_name' => 'required|min:5|max:150',
                'summary'=> 'nullable',
                'cover_image'=> 'nullable|image|max:512',
                'type_id'=> 'nullable|exists:types,id'
            ],
            [
                'name.required' => 'Campo obbligatorio',
                'name.min' => 'Minino 5 caratteri',
                'name.max' => 'Massimo 200 caratteri',
                'client_name.required' => 'Campo obbligatorio',
                'client_name.min' => 'Minino 5 caratteri',
                'client_name.max' => 'Massimo 150 caratteri',
                'cover_image.image'=> 'Il file deve essere un\'immagine (jpg, jpeg, png, bmp, gif, svg o webp).',
                'type_id'=> 'Selezione non valida'
            ]
        );

        $formData = $request->all();

        if($request->hasFile('cover_image')){
            $img_path = Storage::disk('public')->put('project_images', $formData['cover_image']);
            
            $formData['cover_image'] = $img_path;
        };

        $newProject = new Project(); 

        // $newProject->name = $formData['name'];
        // $newProject->client_name = $formData['client_name'];
        // $newProject->summary = $formData['summary'];

        $newProject->fill($formData);
        $newProject->slug = Str::slug($newProject->name, '-');
        $newProject->save();

        session()->flash('success', 'Progetto creato con successo!');

        return redirect()->route('admin.projects.show', ['project' => $newProject->slug]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {

        $data = [
            'project' => $project
        ];
        
        return view('admin.projects.show', $data);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();

        $data = [
            'project' => $project,
            'types'=>$types
        ];


        return view('admin.projects.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate(
            [
                'name' => 'required|min:5|max:200',
                'client_name' => 'required|min:5|max:150',
                'summary'=> 'nullable',
                'cover_image'=> 'nullable|image|max:512',
                'type_id'=> 'nullable|exists:types,id'
            ],
            [
                'name.required' => 'Campo obbligatorio',
                'name.min' => 'Minino 5 caratteri',
                'name.max' => 'Massimo 200 caratteri',
                'client_name.required' => 'Campo obbligatorio',
                'client_name.min' => 'Minino 5 caratteri',
                'client_name.max' => 'Massimo 150 caratteri',
                'cover_image.image'=> 'Il file deve essere un\'immagine (jpg, jpeg, png, bmp, gif, svg o webp).',
                'type_id'=> 'Selezione non valida'
            ]
        );
        
        $formData = $request->all();

        if($request->hasFile('cover_image')){
            if($project->cover_image){
                Storage::delete($project->cover_image);
            }

            $img_path = Storage::disk('public')->put('project_images', $formData['cover_image']);
            
            $formData['cover_image'] = $img_path;
        };

        $project->slug = Str::slug($formData['name'], '-');
        $project->update($formData);
        

        session()->flash('success', 'Progetto modificato con successo!');

        return redirect()->route('admin.projects.show', ['project' => $project->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index');
    }
}
