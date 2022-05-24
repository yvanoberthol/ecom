@extends('backend.layouts.app')

@section('content')

<div class="col-lg-7 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Role Information')}}</h5>
        </div>
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-3 col-from-label" for="name">{{translate('Name')}}</label>
                    <div class="col-md-9">
                        <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Permissions') }}</h5>
                </div>
                <br>
                <div class="form-group row">
                    <label class="col-md-2 col-from-label"></label>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Products') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="2">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('All Orders') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="3">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Inhouse orders') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="4">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Seller Orders') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="5">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Pick-up Point Order') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="6">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Customers') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="8">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Sellers') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="9">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Reports') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="10">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Marketing') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="11">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Support') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="12">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Website Setup') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="13">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Setup & Configurations') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="14">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Staffs') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="20">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Uploaded Files') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="22">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Blog System') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="23">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('System') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="24">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                </div>
            </div>
        </from>
    </div>
</div>

@endsection
