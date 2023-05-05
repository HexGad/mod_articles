@extends('dashboard.layouts.base')
@section('toolbar')
    @include('dashboard.layouts.components.toolbar',[
        'title' => 'Articles',
        'breadcrumbs' => [
            ['title'=> 'Home', 'url' => url('/dashboard/')],
            ['title'=> 'Articles', 'url' => route('dashboard.articles.index')],
            ['title'=> 'Edit Articles'],
        ]
    ])
@endsection

@push('styles')
    {{ module_vite('articles', 'resources/assets/sass/app.scss') }}
@endpush


@section('content')
    <div id="app">
        <edit
                :categories="{{json_encode($categories)}}"
                :forms="{{json_encode($forms)}}"
                :pixels="{{json_encode($pixels)}}"
                :article-data="{{json_encode($article)}}">
        </edit>
    </div>
@endsection

@push('scripts')
    {{ module_vite('articles', 'resources/assets/js/app.js') }}
@endpush
