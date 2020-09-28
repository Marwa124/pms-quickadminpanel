<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProposalRequest;
use App\Http\Requests\StoreProposalRequest;
use App\Http\Requests\UpdateProposalRequest;
use App\Models\Permission;
use App\Models\Proposal;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ProposalsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('proposal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proposals = Proposal::all();

        $permissions = Permission::get();

        return view('admin.proposals.index', compact('proposals', 'permissions'));
    }

    public function create()
    {
        abort_if(Gate::denies('proposal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $premissions = Permission::all()->pluck('title', 'id');

        return view('admin.proposals.create', compact('premissions'));
    }

    public function store(StoreProposalRequest $request)
    {
        $proposal = Proposal::create($request->all());
        $proposal->premissions()->sync($request->input('premissions', []));

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $proposal->id]);
        }

        return redirect()->route('admin.proposals.index');
    }

    public function edit(Proposal $proposal)
    {
        abort_if(Gate::denies('proposal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $premissions = Permission::all()->pluck('title', 'id');

        $proposal->load('premissions');

        return view('admin.proposals.edit', compact('premissions', 'proposal'));
    }

    public function update(UpdateProposalRequest $request, Proposal $proposal)
    {
        $proposal->update($request->all());
        $proposal->premissions()->sync($request->input('premissions', []));

        return redirect()->route('admin.proposals.index');
    }

    public function show(Proposal $proposal)
    {
        abort_if(Gate::denies('proposal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proposal->load('premissions');

        return view('admin.proposals.show', compact('proposal'));
    }

    public function destroy(Proposal $proposal)
    {
        abort_if(Gate::denies('proposal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proposal->delete();

        return back();
    }

    public function massDestroy(MassDestroyProposalRequest $request)
    {
        Proposal::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('proposal_create') && Gate::denies('proposal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Proposal();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
