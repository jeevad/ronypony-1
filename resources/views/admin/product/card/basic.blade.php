<div class="row">
    <div class="col-6">
        @include('admin.forms.text',['name' => 'name','label' => 'Name'])
    </div>
    <div class="col-6">
        @if(!isset($productCategories))
            <?php $productCategories = []; ?>
        @endif

        @include('admin.forms.select2',['name' => 'category_id[]',
                                                'label' => 'Category',
                                                'attributes' => ['class' => 'form-control select2',
                                                                'id' => 'category_id',
                                                                'multiple' => true,
                                                                ],
                                                'options' => $categoryOptions,
                                                'values' => $productCategories])


    </div>
</div>


<div class="row">
    <div class="col-6">
        @include('admin.forms.text',['name' => 'slug','label' => 'Slug'])
    </div>
    <div class="col-6">
        @include('admin.forms.text',['name' => 'sku','label' => 'Sku'])
    </div>
</div>

@include('admin.forms.textarea',['name' => 'description','label' => 'Description',
                                            'attributes' => ['class' => 'summernote','id' => 'description']])

<div class="row">
    @if($model->type == "VARIATION")
        <div class="col-6">
            @include('admin.forms.text',['name' => 'price','label' => 'Base Price'])
        </div>
    @else
        <div class="col-6">
            @include('admin.forms.text',['name' => 'price','label' => 'Price'])
        </div>
    @endif
    <div class="col-6">
        @include('admin.forms.select',['name' => 'status','label' => 'Status', 'options' => ['1' => 'Enabled','0' => 'Disabled']])
    </div>
</div>


<div class="row">
    <div class="col-6">
        @include('admin.forms.text',['name' => 'qty','label' => 'Qty'])
    </div>
    <div class="col-6">
        @include('admin.forms.select',['name' => 'in_stock','label' => 'In Stock', 'options' => ['1' => 'Enabled','0' => 'Disabled']])
    </div>
</div>

<div class="row">
    <div class="col-6">
        @include('admin.forms.select',['name' => 'track_stock','label' => 'Track Stock', 'options' => ['1' => 'Enabled','0' => 'Disabled']])

    </div>
    <div class="col-6">
        @include('admin.forms.select',['name' => 'is_taxable','label' => 'Is taxable', 'options' => ['1' => 'Enabled','0' => 'Disabled']])
    </div>
</div>


@if($model->type !== "DOWNLOADABLE")
<div class="row">
    <div class="col-md-12">
        @include('admin.forms.text',['name' => 'weight','label' => 'Weight'])
    </div>


</div>

<div class="row">
    <div class="col-4">
        @include('admin.forms.text',['name' => 'width','label' => 'Width'])
    </div>
    <div class="col-4">
        @include('admin.forms.text',['name' => 'height','label' => 'height'])
    </div>
    <div class="col-4">
        @include('admin.forms.text',['name' => 'length','label' => 'Length'])
    </div>


</div>
@endif
@push('scripts')
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script type="text/javascript">    
    $(document).ready(function() {
        $('.summernote').summernote({});
      });
</script>
@endpush