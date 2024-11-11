<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="batchno" class="form-label">{{ __('Batchno') }}</label>
            <input type="text" name="batchno" class="form-control @error('batchno') is-invalid @enderror" value="{{ old('batchno', $batch?->batchno) }}" id="batchno" placeholder="Batchno">
            {!! $errors->first('batchno', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="batch_size" class="form-label">{{ __('Batch Size') }}</label>
            <input type="text" name="batch_size" class="form-control @error('batch_size') is-invalid @enderror" value="{{ old('batch_size', $batch?->batch_size) }}" id="batch_size" placeholder="Batch Size">
            {!! $errors->first('batch_size', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="product_id" class="form-label">{{ __('Product Id') }}</label>
            <input type="text" name="product_id" class="form-control @error('product_id') is-invalid @enderror" value="{{ old('product_id', $batch?->product_id) }}" id="product_id" placeholder="Product Id">
            {!! $errors->first('product_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="mfg_date" class="form-label">{{ __('Mfg Date') }}</label>
            <input type="text" name="mfg_date" class="form-control @error('mfg_date') is-invalid @enderror" value="{{ old('mfg_date', $batch?->mfg_date) }}" id="mfg_date" placeholder="Mfg Date">
            {!! $errors->first('mfg_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="exp_date" class="form-label">{{ __('Exp Date') }}</label>
            <input type="text" name="exp_date" class="form-control @error('exp_date') is-invalid @enderror" value="{{ old('exp_date', $batch?->exp_date) }}" id="exp_date" placeholder="Exp Date">
            {!! $errors->first('exp_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="status" class="form-label">{{ __('Status') }}</label>
            <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status', $batch?->status) }}" id="status" placeholder="Status">
            {!! $errors->first('status', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="created_by" class="form-label">{{ __('Created By') }}</label>
            <input type="text" name="created_by" class="form-control @error('created_by') is-invalid @enderror" value="{{ old('created_by', $batch?->created_by) }}" id="created_by" placeholder="Created By">
            {!! $errors->first('created_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="updated_by" class="form-label">{{ __('Updated By') }}</label>
            <input type="text" name="updated_by" class="form-control @error('updated_by') is-invalid @enderror" value="{{ old('updated_by', $batch?->updated_by) }}" id="updated_by" placeholder="Updated By">
            {!! $errors->first('updated_by', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>