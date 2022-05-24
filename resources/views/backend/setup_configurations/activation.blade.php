@extends('backend.layouts.app')

@section('content')

<h4 class="text-center text-muted">{{translate('System')}}</h4>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
            	<h5 class="mb-0 h6 text-center">{{translate('HTTPS Activation')}}</h5>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'FORCE_HTTPS')" <?php if(env('FORCE_HTTPS') == 'On') echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center">{{translate('Maintenance Mode Activation')}}</h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'maintenance_mode')" <?php if(get_setting('maintenance_mode') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center">{{translate('Disable image encoding?')}}</h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'disable_image_optimization')" <?php if(get_setting('disable_image_optimization') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</div>


<h4 class="text-center text-muted mt-4">{{translate('Business Related')}}</h4>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center">{{translate('Classified Product')}}</h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'classified_product')" <?php if(get_setting('classified_product') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center">{{translate('Conversation Activation')}}</h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'conversation_system')" <?php if(get_setting('conversation_system') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center">{{translate('Email Verification')}}</h3>
            </div>
            <div class="card-body text-center">
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateSettings(this, 'email_verification')" <?php if(get_setting('email_verification') == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    You need to configure SMTP correctly to enable this feature. <a href="{{ route('smtp_settings.index') }}">Configure Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<h4 class="text-center text-muted mt-4">{{translate('Payment Related')}}</h4>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6 text-center">{{translate('Cash Payment Activation')}}</h3>
            </div>
            <div class="card-body text-center">
                <div class="clearfix">
                    <img class="float-left" src="{{ static_asset('assets/img/cards/cod.png') }}" height="30">
                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'cash_payment')" <?php if(get_setting('cash_payment') == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('script')
    <script type="text/javascript">
        function updateSettings(el, type){
            let value;
            if($(el).is(':checked')){
                value = 1;
            }
            else{
                value = 0;
            }
            
            $.post('{{ route('business_settings.update.activation') }}', {_token:'{{ csrf_token() }}', type:type, value:value}, function(data){
                if(data === '1'){
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
