<select class="form-control" id="categories" name="categories[]" multiple="multiple">
    @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ $selected->contains($category->id) ? 'selected' : '' }}>{{  $category->name }}</option>
    @endforeach
</select>