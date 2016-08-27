<label class="custom-control custom-radio">
    <input name="{{ $name }}" {{ $checked ? 'checked' : '' }} type="radio" class="custom-control-input">
    <span class="custom-control-indicator"></span>
    <span class="custom-control-description">{!! $label !!}</span>
</label>
