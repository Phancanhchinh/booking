@component('mail::message')
<h3>Xin chào [{{ $fullName }}]</h3>

<p>Vui lòng click vào đường dẫn bên dưới đên kích hoạt tài khoản.</p>

@component('mail::button', ['url' => $urlActive.$token])
{{ trans('Kích hoạt ngay')}}
@endcomponent

<p>Vui lòng bỏ qua nếu bạn không thực hiện hành động này.<br>
</p>

@endcomponent
