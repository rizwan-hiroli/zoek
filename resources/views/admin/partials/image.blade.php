<div class="text-center">
	@if(isset($directory))
		<a href="{{asset("$directory")}}" data-lightbox="{{$imageName ?? null}}" rel="lightbox" class='imageHover'>
			<img src='{{asset("$directory")}}' class='imageHover' alt='image' width='42'>
		</a>
	@else
		NA
	@endif
</div>