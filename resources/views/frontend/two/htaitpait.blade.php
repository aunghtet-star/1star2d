@extends('frontend.layouts.app')
@section('htaitpait','active')

@section('extra_css')
   <style>
       .error{
           color: red;
           border-color: red;
       }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($errors->all() as $error)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{$error}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endforeach
            @if($htaitpaitform->status == 'show')
            <div class="card">
                <div class="col-12 mt-3">
                    <h5 class="text-center">Thai အမြန်ထိုးရန်</h5>
                </div>

                <div class="card-body">
                    <form action="{{url('two/htaitpait/confirm')}}" method="POST" >
                        @csrf
                        <h5 class="text-center text-success mb-3">ထိပ်ဂဏန်းများ</h5>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="zerohtait">
                                              <input type="checkbox" class="form-check-input" name="zerohtait" id="zerohtait" value="00-01-02-03-04-05-06-07-08-09" >
                                              0 ထိပ်
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="onehtait">
                                              <input type="checkbox" class="form-check-input" name="onehtait" id="onehtait" value="10-11-12-13-14-15-16-17-18-19" >
                                              1 ထိပ်
                                            </label>
                                          </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="twohtait">
                                              <input type="checkbox" class="form-check-input" name="twohtait" id="twohtait" value="20-21-22-23-24-25-26-27-28-29" >
                                              2 ထိပ်
                                            </label>
                                          </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 text-center">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="threehtait">
                                              <input type="checkbox" class="form-check-input" name="threehtait" id="threehtait" value="30-31-32-33-34-35-36-37-38-39" >
                                              3 ထိပ်
                                            </label>
                                          </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="fourhtait">
                                              <input type="checkbox" class="form-check-input" name="fourhtait" id="fourhtait" value="40-41-42-43-44-45-46-47-48-49" >
                                              4 ထိပ်
                                            </label>
                                          </div>
                                    </div>


                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="fivehtait">
                                              <input type="checkbox" class="form-check-input" name="fivehtait" id="fivehtait" value="50-51-52-53-54-55-56-57-58-59" >
                                              5 ထိပ်
                                            </label>
                                          </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 text-center">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="sixhtait">
                                              <input type="checkbox" class="form-check-input" name="sixhtait" id="sixhtait" value="60-61-62-63-64-65-66-67-68-69" >
                                              6 ထိပ်
                                            </label>
                                          </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="sevenhtait">
                                              <input type="checkbox" class="form-check-input" name="sevenhtait" id="sevenhtait" value="70-71-72-73-74-75-76-77-78-79" >
                                              7 ထိပ်
                                            </label>
                                          </div>
                                    </div>


                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="eighthtait">
                                              <input type="checkbox" class="form-check-input" name="eighthtait" id="eighthtait" value="80-81-82-83-84-85-86-87-88-89" >
                                              8 ထိပ်
                                            </label>
                                          </div></div>
                                    </div>
                                </div>

                            <div class="col-12 text-center">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="ninehtait">
                                              <input type="checkbox" class="form-check-input" name="ninehtait" id="ninehtait" value="90-91-92-93-94-95-96-97-98-99" >
                                              9 ထိပ်
                                            </label>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ------------------------------nout pait--------------------------- --}}

                        <h5 class="text-center text-success mb-3">နောက်ဂဏန်းများ</h5>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="zeropait">
                                              <input type="checkbox" class="form-check-input" name="zeropait" id="zeropait" value="00-10-20-30-40-50-60-70-80-90" >
                                              0 ပိတ်
                                            </label>
                                          </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="onepait">
                                              <input type="checkbox" class="form-check-input" name="onepait" id="onepait" value="01-11-21-31-41-51-61-71-81-91" >
                                              1 ပိတ်
                                            </label>
                                          </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="twopait">
                                              <input type="checkbox" class="form-check-input" name="twopait" id="twopait" value="02-12-22-32-42-52-62-72-82-92" >
                                              2 ပိတ်
                                            </label>
                                          </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="threepait">
                                              <input type="checkbox" class="form-check-input" name="threepait" id="threepait" value="03-13-23-33-43-53-63-73-83-93" >
                                              3 ပိတ်
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="fourpait">
                                              <input type="checkbox" class="form-check-input" name="fourpait" id="fourpait" value="04-14-24-34-44-54-64-74-84-94" >
                                              4 ပိတ်
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="fivepait">
                                              <input type="checkbox" class="form-check-input" name="fivepait" id="fivepait" value="05-15-25-35-45-55-65-75-85-95" >
                                              5 ပိတ်
                                            </label>
                                          </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="sixpait">
                                              <input type="checkbox" class="form-check-input" name="sixpait" id="sixpait" value="06-16-26-36-46-56-66-76-86-96" >
                                              6 ပိတ်
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="sevenpait">
                                              <input type="checkbox" class="form-check-input" name="sevenpait" id="sevenpait" value="07-17-27-37-47-57-67-77-87-97" >
                                              7 ပိတ်
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="eightpait">
                                              <input type="checkbox" class="form-check-input" name="eightpait" id="eightpait" value="08-18-28-38-48-58-68-78-88-98" >
                                              8 ပိတ်
                                            </label>
                                          </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="ninepait">
                                                <input type="checkbox" class="form-check-input" name="ninepait" id="ninepait" value="09-19-29-39-49-59-69-79-89-99" >
                                                9 ပိတ်
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                {{-- ========================== brake ========================== --}}
                        <h5 class="text-center text-success mb-3">ဘရိတ်</h5>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="zerobrake">
                                              <input type="checkbox" class="form-check-input" name="zerobrake" id="zerobrake" value="55-28-37-46-91-82-73-64-19-00" >
                                              0 ဘရိတ်
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="onebrake">
                                              <input type="checkbox" class="form-check-input" name="onebrake" id="onebrake" value="10-29-38-47-56-01-92-83-74-65" >
                                              1 ဘရိတ်
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="twobrake">
                                              <input type="checkbox" class="form-check-input" name="twobrake" id="twobrake" value="11-02-39-48-75-66-20-93-84-57" >
                                              2 ဘရိတ်
                                            </label>
                                          </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="threebrake">
                                              <input type="checkbox" class="form-check-input" name="threebrake" id="threebrake" value="12-03-49-58-67-21-30-94-85-76" >
                                              3 ဘရိတ်
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="fourbrake">
                                              <input type="checkbox" class="form-check-input" name="fourbrake" id="fourbrake" value="13-22-04-59-86-77-31-40-95-68" >
                                              4 ဘရိတ်
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="fivebrake">
                                              <input type="checkbox" class="form-check-input" name="fivebrake" id="fivebrake" value="14-23-05-78-96-41-32-50-87-69" >
                                              5 ဘရိတ်
                                            </label>
                                          </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="sixbrake">
                                              <input type="checkbox" class="form-check-input" name="sixbrake" id="sixbrake" value="15-24-33-88-79-06-51-42-97-60" >
                                              6 ဘရိတ်
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="sevenbrake">
                                              <input type="checkbox" class="form-check-input" name="sevenbrake" id="sevenbrake" value="16-25-34-07-89-61-52-43-70-98" >
                                              7 ဘရိတ်
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="eightbrake">
                                              <input type="checkbox" class="form-check-input" name="eightbrake" id="eightbrake" value="08-17-26-35-44-99-80-71-62-53" >
                                              8 ဘရိတ်
                                            </label>
                                          </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="ninebrake">
                                            <input type="checkbox" class="form-check-input" name="ninebrake" id="ninebrake" value="09-18-27-36-45-90-81-72-63-54" >
                                            9 ဘရိတ်
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- ========================== a par ========================== --}}

                        <h5 class="text-center text-success mb-3">ပတ်ဂဏန်းများ</h5>
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="zeropar">
                                              <input type="checkbox" class="form-check-input" name="zeropar" id="zeropar" value="00-01-02-03-04-05-06-07-08-09-10-20-30-40-50-60-70-80-90" >
                                              0 အပါ
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="onepar">
                                              <input type="checkbox" class="form-check-input" name="onepar" id="onepar" value="10-11-12-13-14-15-16-17-18-19-01-21-31-41-51-61-71-81-91" >
                                              1 အပါ
                                            </label>
                                          </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="twopar">
                                              <input type="checkbox" class="form-check-input" name="twopar" id="twopar" value="20-21-22-23-24-25-26-27-28-29-02-12-32-42-52-62-72-82-92" >
                                              2 အပါ
                                            </label>
                                          </div>
                                    </div>
                                </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <label class="form-check-label" id="threepar">
                                          <input type="checkbox" class="form-check-input" name="threepar" id="threepar" value="30-31-32-33-34-35-36-37-38-39-03-13-23-43-53-63-73-83-93" >
                                          3 အပါ
                                        </label>
                                      </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <label class="form-check-label" id="fourpar">
                                          <input type="checkbox" class="form-check-input" name="fourpar" id="fourpar" value="40-41-42-43-44-45-46-47-48-49-04-14-24-34-54-64-74-84-94" >
                                          4 အပါ
                                        </label>
                                      </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <label class="form-check-label" id="fivepar">
                                          <input type="checkbox" class="form-check-input" name="fivepar" id="fivepar" value="50-51-52-53-54-55-56-57-58-59-05-15-25-35-45-65-75-85-95" >
                                          5 အပါ
                                        </label>
                                      </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <label class="form-check-label" id="sixpar">
                                          <input type="checkbox" class="form-check-input" name="sixpar" id="sixpar" value="60-61-62-63-64-65-66-67-68-69-06-16-26-36-46-56-76-86-96" >
                                          6 အပါ
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <label class="form-check-label" id="sevenpar">
                                          <input type="checkbox" class="form-check-input" name="sevenpar" id="sevenpar" value="70-71-72-73-74-75-76-77-78-79-07-17-27-37-47-57-67-87-97" >
                                          7 အပါ
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <label class="form-check-label" id="eightpar">
                                          <input type="checkbox" class="form-check-input" name="eightpar" id="eightpar" value="80-81-82-83-84-85-86-87-88-89-08-18-28-38-48-58-68-78-98" >
                                          8 အပါ
                                        </label>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label" id="ninepar">
                                              <input type="checkbox" class="form-check-input" name="ninepar" id="ninepar" value="90-91-92-93-94-95-96-97-98-99-09-19-29-39-49-59-69-79-89" >
                                              9 အပါ
                                            </label>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- ========================== a puu ========================== --}}

                        <h5 class="text-center text-success">အပူး</h5>
                        <div class="row mb-3">
                            <div class="col-12 text-center pl-0">
                                <div class="col-5">
                                    <div class="form-check">
                                        <label class="form-check-label" id="apuu">
                                          <input type="checkbox" class="form-check-input" name="apuu" id="apuu" value="00-11-22-33-44-55-66-77-88-99" >
                                          အပူး
                                        </label>
                                      </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="text-center text-success">ဆယ်ပြည့်</h5>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <div class="col-5">
                                    <div class="form-check">
                                        <label class="form-check-label" id="ten">
                                          <input type="checkbox" class="form-check-input" name="ten" id="ten" value="10-20-30-40-50-60-70-80-90" >
                                          ဆယ်ပြည့်
                                        </label>
                                      </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="text-center text-success">ပါဝါ</h5>
                        <div class="row mb-3">
                            <div class="col-12 text-center" style="padding-left: 2px">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-check">
                                            <label class="form-check-label" id="power">
                                              <input type="checkbox" class="form-check-input" name="power" id="power" value="16-27-38-49-50-61-72-83-94-05" >
                                              ပါဝါ
                                            </label>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="text-center text-success">နက္ခတ်</h5>
                        <div class="row mb-3">
                            <div class="col-12 text-center" style="padding-left: 12px">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-check">
                                            <label class="form-check-label" id="natkhat">
                                              <input type="checkbox" class="form-check-input" name="natkhat" id="natkhat" value="18-24-35-69-70-81-42-53-96-07" >
                                              နက္ခတ်
                                            </label>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 class="text-center text-success">ညီအကို</h5>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-check">
                                            <label class="form-check-label" id="brother">
                                              <input type="checkbox" class="form-check-input" name="brother" id="brother" value="12-23-34-45-56-67-78-89-90-01-21-32-43-54-65-76-87-98-09-10" >
                                              ညီအကို
                                            </label>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-12 p-0">
                            <div class="form-group">
                                <label for="">Amount</label>
                                <input type="number" name="amount" class="form-control">
                            </div>
                        </div>
                        <button type="submit" id="checkBtn" class="btn btn-primary m-0 btn-sm" style="font-weight: 700 ">ထိုးမည်</button>
                  </div>
                </form>
            </div>
            @else
            <div class="d-flex justify-content-center align-items-center" style="height:100vh">
              <h4 class="text-center text-danger" style="font-weight: 700;">ပိတ်ထားပါသည်</h4>
          </div>
            @endif
        </div>
    </div>
</div>
</div>

@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreHtaitPait') !!}

<script>
    $(document).ready(function(){



        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })

            $('#checkBtn').click(function() {
              checked = $("input[type=checkbox]:checked").length;

              if(!checked) {

                Toast.fire({
                icon: 'error',
                title: 'အနည်းဆုံးတစ်ခုရွေးပေးပါ'
                })
                  return false;
              }

            });



            @if(session('create'))
            Toast.fire({
            icon: 'success',
            title: '{{session('create')}}'
            })
            @endif()

    })
</script>

@endsection
