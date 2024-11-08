@extends('admin.layouts.app')


@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Pack Form</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('pack-forms.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('admin.pack-form.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
