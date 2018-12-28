<div class="card mt-3 mb-3">
    <div class="card-header">Basic Details</div>
    <div class="card-body">
        @include("admin.forms.text",['name'=> 'name','label' => 'Name','value'=> $model->name ?? ""])
        @include("admin.forms.text",['name'=> 'slug','label' => 'Role Slug','value'=> $model->slug ?? ""])
    </div>
</div>