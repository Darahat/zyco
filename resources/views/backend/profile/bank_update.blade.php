<!-- Main content -->

<div class="tab-content-heading-div">
    <div class="row">
        <div class="col-md-6">
            <div class="tab-content-heading">Company</div>
            <div class="tab-content-muted-text">Manage your company informations
            </div>
        </div>

    </div>
    <hr />
    <br>

    <form action="{{route('updateBank')}}" method="post" enctype="multipart/form-data">

        @csrf

        <?php

        if ($bankInfo) :
            $IBAN = $bankInfo->IBAN;
            $BIC = $bankInfo->BIC;
            $account_holder_name = $bankInfo->account_holder_name;
            $note_area = $bankInfo->note_area;
            $bankInfo_id = $bankInfo->id;
        else :
            $IBAN = "";
            $BIC = "";
            $account_holder_name = "";
            $note_area = "";
            $bankInfo_id = "";

        endif;
        ?>

        <div class="row">
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="input_vehicle_name" class="col-sm-12 control-label input-box-label">IBAN<em
                            class="text-danger">*</em></label>
                    <div class="col-md-12 col-sm-offset-1">
                        <input type="text" name="IBAN" placeholder="IBAN" id="IBAN" value="{{ $IBAN}}"
                            class="form-control input-box" required>
                        <span class="text-danger">{{ $errors->first('IBAN') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="input_vehicle_name" class="col-sm-12 control-label input-box-label">BIC<em
                            class="text-danger">*</em></label>
                    <div class="col-md-12 col-sm-offset-1">
                        <input type="text" name="BIC" placeholder="BIC" id="BIC" value="{{ $BIC}}"
                            class="form-control input-box" required>
                        <span class="text-danger">{{ $errors->first('BIC') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="input_vehicle_name" class="col-sm-12 control-label input-box-label">Account Holder
                        Name<em class="text-danger">*</em></label>
                    <div class="col-md-12 col-sm-offset-1">
                        <input type="text" name="account_holder_name" placeholder="account_holder_name"
                            id="account_holder_name" value="{{ $account_holder_name}}" class="form-control input-box"
                            required>
                        <span class="text-danger">{{ $errors->first('account_holder_name') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="input_vehicle_name" class="col-sm-12 control-label input-box-label">Note Area<em
                            class="text-danger">*</em></label>
                    <div class="col-md-12 col-sm-offset-1">
                        <textarea name="note_area" placeholder="note_area" id="note_area" value="{{ $note_area}}"
                            class="form-control input-box" required>{{ $note_area }}</textarea>
                        <span class="text-danger">{{ $errors->first('note_area') }}</span>
                    </div>
                </div>
            </div>

            <div class="pb-2 row">

                <div class="col-sm-3"></div>

                <div class="col-sm-3">

                    <input type="hidden" name="id" value="{{ $bankInfo_id }}">

                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>

                </div>

            </div>



    </form>



</div>

<!-- /.card-body -->



<!-- /.card-footer-->

</div>