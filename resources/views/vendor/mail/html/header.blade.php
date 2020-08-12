<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="http://ghanadriver.com/vendor/landing-page/img/gdlogo.jpg" class="logo" alt="GhanaDriver Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
