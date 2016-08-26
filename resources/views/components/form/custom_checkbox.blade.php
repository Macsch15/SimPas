<label class="custom-control custom-checkbox">
    <input name="{{ $name }}" {{ $checked ? 'checked' : '' }} type="checkbox" class="custom-control-input">
    <span class="custom-control-indicator"></span>
    <span class="custom-control-description">{{ $label }}</span>
</label>
