
@extends('layouts.visitor.body')
@section('content')

<div>
    <h1 class="text-primary" align="center">Extract Text from Memoire</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ route('visiteur.extractMemoireText') }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label for="memoireId">Memoire ID</label>
                <input type="text" class="form-control" id="memoireId" placeholder="Enter the Memoire ID" name="projId">
            </div>
            <div class="form-group" style="padding:20px 0px;">
                <button type="submit" class="btn btn-primary">Extract Text</button>
            </div>
        </div>
    </form>

    @if(isset($pdfText) && $pdfText !== 'Memoire not found' && $pdfText !== 'Memoire file not found')
    <div class="mt-4">
        <h2>Extracted Text from Memoire</h2>
        <p>{!! nl2br(e($pdfText)) !!}</p>
    </div>
    @elseif($pdfText === 'Memoire not found')
    <div class="mt-4">
        <h2>Memoire Not Found</h2>
    </div>
    @elseif($pdfText === 'Memoire file not found')
    <div class="mt-4">
        <h2>Memoire File Not Found</h2>
    </div>
    @endif

</div>
@endsection










{{-- @extends('layouts.visitor.body')
@section('content')

<div>
    <h1 class="text-primary" align="center">Extract Text from Memoire</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ route('visiteur.extractMemoireText/1') }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label for="memoireId">Memoire ID</label>
                <input type="text" class="form-control" id="memoireId" placeholder="Enter the Memoire ID" name="projId">
            </div>
            <div class="form-group" style="padding:20px 0px;">
                <button type="submit" class="btn btn-primary">Extract Text</button>
            </div>
        </div>
    </form>

    @if(isset($pdfText) && $pdfText !== 'Memoire not found' && $pdfText !== 'Memoire file not found')
    <div class="mt-4">
        <h2>Extracted Text from Memoire</h2>
        <p>{!! nl2br(e($pdfText)) !!}</p>
    </div>
    @elseif($pdfText === 'Memoire not found')
    <div class="mt-4">
        <h2>Memoire Not Found</h2>
    </div>
    @elseif($pdfText === 'Memoire file not found')
    <div class="mt-4">
        <h2>Memoire File Not Found</h2>
    </div>
    @endif

</div>
@endsection --}}













{{-- @extends('layouts.visitor.body')
@section('content')

<div>
    <h1 class="text-primary" align="center">Extract Text from Memoire</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ route('visiteur.extractMemoireText') }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label for="memoireId">Memoire ID</label>
                <input type="text" class="form-control" id="memoireId" placeholder="Enter the Memoire ID" name="projId">
            </div>
            <div class="form-group" style="padding:20px 0px;">
                <button type="submit" class="btn btn-primary">Extract Text</button>
            </div>
        </div>
    </form>

    @if(isset($pdfText) && $pdfText !== 'Memoire not found' && $pdfText !== 'Memoire file not found')
    <div class="mt-4">
        <h2>Extracted Text from Memoire</h2>
        <p>{!! nl2br(e($pdfText)) !!}</p>
    </div>
    @elseif($pdfText === 'Memoire not found')
    <div class="mt-4">
        <h2>Memoire Not Found</h2>
    </div>
    @elseif($pdfText === 'Memoire file not found')
    <div class="mt-4">
        <h2>Memoire File Not Found</h2>
    </div>
    @endif

</div>
@endsection --}}


{{-- 
@extends('layouts.visitor.body')
@section('content')

<div>
    <h1 class="text-primary" align="center">Extract Text from Memoire</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ route('visiteur.extractMemoireText') }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label for="memoireId">Memoire ID</label>
                <input type="text" class="form-control" id="memoireId" placeholder="Enter the Memoire ID" name="projId">
            </div>
            <div class="form-group" style="padding:20px 0px;">
                <button type="submit" class="btn btn-primary">Extract Text</button>
            </div>
        </div>
    </form>

    @if(isset($pdfText) && $pdfText !== 'Memoire not found' && $pdfText !== 'Memoire file not found')
    <div class="mt-4">
        <h2>Extracted Text from Memoire</h2>
        <p>{!! nl2br(e($pdfText)) !!}</p>
    </div>
    @elseif($pdfText === 'Memoire not found')
    <div class="mt-4">
        <h2>Memoire Not Found</h2>
    </div>
    @elseif($pdfText === 'Memoire file not found')
    <div class="mt-4">
        <h2>Memoire File Not Found</h2>
    </div>
    @endif

</div>
@endsection --}}
