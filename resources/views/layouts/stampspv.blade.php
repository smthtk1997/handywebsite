<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Stampspv</title>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Prompt:300" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">    <style>
        .inputColor{
            background-color: #1b1e21;
            color: white;
        }
    </style>
    
</head>
<body>
<div class="container pt-5">
    <h1>Stampspv CRUD Generator for Laravel 5.7 Online</h1>
    <small>by stampspv.</small>




    <hr>
    <h4>Step 1 : Create Model</h4>
    <div class="input-group mb-3 input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text">Model name</span>
        </div>
        <input type="text" class="form-control" placeholder="Ex. Room" id="modelname">
    </div>
    <div class="input-group mb-3 input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text">CLI</span>
        </div>
        <input type="text" class="form-control inputColor" value="" id="step1cli">
    </div>





    <hr class="pt-5">
    <h4>Step 2 : Create Database </h4>
    <button class="btn btn-success m-2" id="btnAddRow">New Row</button>
    <div id="textareDBZone">
        <div class="row mt-1" id="each">
            <div class="col-2">
                <input type="text" class="form-control" value="" id="data0" placeholder="name">
            </div>
            <div class="col-9">
                <label class="radio-inline">
                    <input type="radio" id="optradio0" name="optradio0" value="0" checked> String
                </label>
                <label class="radio-inline">
                    <input type="radio" id="optradio0" name="optradio0" value="1"> Text
                </label>
                <label class="radio-inline">
                    <input type="radio" id="optradio0" name="optradio0" value="2"> Integer
                </label>
                <label class="radio-inline">
                    <input type="radio" id="optradio0" name="optradio0" value="3"> Timestamp
                </label>
                <span class="ml-4"></span>
                <label class="checkbox-inline">
                    <input type="checkbox" id="null0"> Nullable
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" id="unique0"> Unique
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" id="default0"> Default = 0
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" id="required0" checked> required
                </label>
            </div>
            <div class="col-1">
                <button class="btn btn-sm btn-danger remove_field">-</button>
            </div>
        </div>
        <div id="databaseRow"></div>
    </div>
    <textarea class="form-control mt-3" rows="10" id="textareaDb"></textarea>
    <div class="input-group mt-3 input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text">CLI</span>
        </div>
        <input type="text" class="form-control inputColor" value="php artisan migrate">
    </div>




    <hr class="pt-5">
    <h4>Step 3 : Routes </h4>
    <textarea class="form-control mt-3" rows="10" id="textareaRoute"></textarea>


    <hr class="pt-5">
    <h4>Step 4 : Controller </h4>
    <textarea class="form-control mt-3" rows="20" id="textareaController"></textarea>



    <hr class="pt-5">
    <h4>Step 5 : Balde with Collective </h4>
    <div class="input-group mb-3 input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text"><p id="folderName"></p></span>
        </div>
        <input type="text" class="form-control inputColor" value="create.blade.php">
    </div>
    <textarea class="form-control mt-3" rows="8" id="textareaBladeCreate"></textarea>

    <div class="input-group mb-3 input-group-lg mt-4">
        <div class="input-group-prepend">
            <span class="input-group-text"><p id="folderName2"></p></span>
        </div>
        <input type="text" class="form-control inputColor" value="edit.blade.php">
    </div>
    <textarea class="form-control mt-3" rows="8" id="textareaBladeEdit"></textarea>
    
    
    <div class="footer" style="margin-bottom: 300px"></div>
</div>
</body>
</html>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function () {
        var rowCount = $('#textareDBZone #each').length;
        var modelLower = $('#modelname').val().toLowerCase()+"s";
        var modelController = $('#modelname').val()+"Controller";
        var modelName = $('#modelname').val();

        $('#modelname').on('keyup',function () {
            if($('#modelname').val()!=""){
                $('#step1cli').val("php artisan make:model "+$('#modelname').val()+" -mcr");

                $('#textareaRoute').text("// ----- "+$('#modelname').val()+" Route ------\n\n");
                modelLower = $('#modelname').val().toLowerCase()+"s";
                $('#folderName').text(modelLower);
                $('#folderName2').text(modelLower);
                modelController = $('#modelname').val()+"Controller";
                modelName = $('#modelname').val();


                $('#textareaRoute').append("Route::get('/"+modelLower+"', [\n\t'as' => '"+modelLower+".index', \n\t'uses' => '"+modelController+"@index']);\n\n");
                $('#textareaRoute').append("Route::get('/"+modelLower+"/create', [\n\t'as' => '"+modelLower+".create', \n\t'uses' => '"+modelController+"@create']);\n\n");
                $('#textareaRoute').append("Route::post('/"+modelLower+"/create', [\n\t'as' => '"+modelLower+".store', \n\t'uses' => '"+modelController+"@store']);\n\n");
                $('#textareaRoute').append("Route::get('/"+modelLower+"/{token}/view', [\n\t'as' => '"+modelLower+".view', \n\t'uses' => '"+modelController+"@view']);\n\n");
                $('#textareaRoute').append("Route::get('/"+modelLower+"/{token}/edit', [\n\t'as' => '"+modelLower+".edit', \n\t'uses' => '"+modelController+"@edit']);\n\n");
                $('#textareaRoute').append("Route::put('/"+modelLower+"/{token}/edit', [\n\t'as' => '"+modelLower+".update', \n\t'uses' => '"+modelController+"@update']);\n\n");
                $('#textareaRoute').append("Route::delete('/"+modelLower+"/{token}/delete', [\n\t'as' => '"+modelLower+".delete', \n\t'uses' => '"+modelController+"@destroy']);\n\n");
                $('#textareaRoute').append("// -----------------------");

            }else{
                $('#step1cli').val("");
                $('#textareaRoute').text("");
                $('#textareaController').text("");

            }

        })
        $("#btnAddRow").click(function(e){
            rowCount = $('#textareDBZone #each').length;
            e.preventDefault();
            $('#databaseRow').before('<div class="row mt-1" id="each">' +
                '<div class="col-2"> <input type="text" class="form-control" value="" id="data'+rowCount+'" placeholder="name"> </div>' +
                '<div class="col-9"> <label class="radio-inline"> <input type="radio" name="optradio'+rowCount+'" id="optradio'+rowCount+'" value="0" checked> String </label> <label class="radio-inline"> <input type="radio" name="optradio'+rowCount+'" id="optradio'+rowCount+'" value="1"> Text </label> <label class="radio-inline"> <input type="radio" name="optradio'+rowCount+'" id="optradio'+rowCount+'" value="2"> Integer </label> <label class="radio-inline"> <input type="radio" name="optradio'+rowCount+'" id="optradio'+rowCount+'" value="3"> Timestamp </label> <span class="ml-4"></span><label class="checkbox-inline"> <input type="checkbox" id="null'+rowCount+'"> Nullable </label> <label class="checkbox-inline"> <input type="checkbox" id="unique'+rowCount+'"> Unique </label> <label class="checkbox-inline"> <input type="checkbox" id="default'+rowCount+'"> Default = 0 </label><label class="checkbox-inline"> <input type="checkbox" id="required'+rowCount+'" checked> required </label></div> <div class="col-1"> <button class="btn btn-sm btn-danger remove_field">-</button> </div></div>');
        });

        $(document).on("click",".remove_field",function(){
            $(this).parent().parent().remove();
        });

        $("#textareDBZone").on('change',function () {
            rowCount = $('#textareDBZone #each').length;
            $('#textareaDb').text("$table->increments('id');\n");

            var createMethod = "public function store(Request $request){\n\t$validated = $request->validate([\n";
            var updateMethod = "\n\npublic function update(Request $request){\n\t$validated = $request->validate([\n";
            var n_ewModel = "\n\t$"+modelLower+" = new "+modelName+"();\n";
            var updateModel = "\n\t$"+modelLower+" = "+modelName+"::where('token', $token)->first();\n\tif (!$"+modelLower+") {\n\t\tAlert::error('Please try again','Not Found "+modelName+"')->persistent('Close');\n\t\treturn back();\n\t}\n";

            var createBlade = "\{\!\! Form::open(['route' => '"+modelLower+".create']) \!\!\}\n\n";
            var updateBlade = "\{\!\! Form::open(['route' => '"+modelLower+".update']) \!\!\}\n@method('put')\n\n";

            for (var i = 0 ; i < rowCount;i++){

                var type = "";
                if($("input[name='optradio"+i+"']:checked").val() == 0){
                    type = "string";
                }else if($("input[name='optradio"+i+"']:checked").val() == 1){
                    type = "text";
                }else if($("input[name='optradio"+i+"']:checked").val() == 2){
                    type = "integer";
                }else if($("input[name='optradio"+i+"']:checked").val() == 3){
                    type = "timestamp";
                }

                var extra = "";
                var validateUnique = "";
                var createBladeRe = "";
                if ($("input[id='null"+i+"']:checked").is(':checked')){
                    extra = extra+"->nullable()";
                }
                if ($("input[id='unique"+i+"']:checked").is(':checked')){
                    extra = extra+"->unique()";
                    validateUnique = "|unique:"+modelLower+","+$('#data'+i).val()+"";
                                    }
                if ($("input[id='default"+i+"']:checked").is(':checked')){
                    extra = extra+"->default(0)";
                }
                if ($("input[id='required"+i+"']:checked").is(':checked')){
                    createMethod += "\t\t'"+$('#data'+i).val()+"' => 'required"+validateUnique+"',\n";
                    updateMethod += "\t\t'"+$('#data'+i).val()+"' => 'required"+validateUnique+"',\n";
                    createBladeRe += ",'required'=>'required'";
                }

                n_ewModel += "\t$"+modelLower+"->"+$('#data'+i).val()+" = $request->"+$('#data'+i).val()+";\n";
                updateModel += "\t$"+modelLower+"->"+$('#data'+i).val()+" = $request->"+$('#data'+i).val()+";\n";

                $('#textareaDb').append("$table->"+type+"(\'"+$('#data'+i).val()+"\')"+extra+";\n");

                createBlade += "\{\!\! Form::text('"+$('#data'+i).val()+"',null,['class'=>'form-control','placeholder'=>'"+$('#data'+i).val()+"'"+createBladeRe+"]); \!\!\}\n\n";
                updateBlade += "\{\!\! Form::text('"+$('#data'+i).val()+"',$"+modelLower+"->"+$('#data'+i).val()+",['class'=>'form-control','placeholder'=>'"+$('#data'+i).val()+"'"+createBladeRe+"]); \!\!\}\n\n";
            }
            n_ewModel += "\t$"+modelLower+"->token = str_random(16);\n"
            n_ewModel += "\ttry{\n\t\t$"+modelLower+"->save();\n\t\tAlert::success('Success', 'Created Successfully')->persistent('Close');\n\t\treturn redirect(route('"+modelLower+".index'));\n\t}catch(\\Exception $x){\n\t\treturn $x;\n\t}\n}";
            updateModel += "\ttry{\n\t\t$"+modelLower+"->save();\n\t\tAlert::success('Success', 'Updated Successfully')->persistent('Close');\n\t\treturn view('"+modelLower+".edit', ['"+modelLower+"' => $"+modelLower+"]);\n\t}catch(\\Exception $x){\n\t\treturn $x;\n\t}\n}\n";
            
            createMethod += "\t]);"+n_ewModel;
            updateMethod += "\t]);"+updateModel;

            createMethod += "\n\npublic function view($token){\n\t$"+modelLower+" = "+modelName+"::where('token', $token)->first();\n\tif ($"+modelLower+") {\n\t\treturn view('"+modelLower+".view', ['"+modelLower+"' => $"+modelLower+"]);\n\t}\n\tAlert::error('Please try again','Not Found "+modelName+"')->persistent('Close');\n\treturn back();\n}";

            createMethod += "\n\npublic function edit($token){\n\t$"+modelLower+" = "+modelName+"::where('token', $token)->first();\n\tif ($"+modelLower+") {\n\t\treturn view('"+modelLower+".edit', ['"+modelLower+"' => $"+modelLower+"]);\n\t}\n\tAlert::error('Please try again','Not Found "+modelName+"')->persistent('Close');\n\treturn back();\n}";

            updateMethod += "\npublic function destroy($token){\n\t$"+modelLower+" = "+modelName+"::where('token', $token)->first();\n\tif ($"+modelLower+") {\n\t\t$"+modelLower+"->delete();\n\t\tAlert::success('Success', 'Deleted Successfully')->persistent('Close');\n\t\treturn redirect(route('"+modelLower+".index'));\n\t}\n\tAlert::error('Please try again','Not Found "+modelName+"')->persistent('Close');\n\treturn back();\n}";



            $('#textareaDb').append("$table->string('token',16);\n");
            $('#textareaDb').append("$table->softDeletes();\n");
            $('#textareaDb').append("$table->timestamps();");


            // ---------------
            $('#textareaController').text("public function index(){ \n\t$"+modelLower+" = "+modelName+"::all(); \n\treturn view('"+modelLower+".index', ['"+modelLower+"' => $"+modelLower+"]); \n}\n\n");
            $('#textareaController').append("public function create(){ \n\treturn view('"+modelLower+".create'); \n}\n\n");
            $('#textareaController').append(createMethod);
            $('#textareaController').append(updateMethod);

            $('#textareaBladeCreate').text(createBlade);
            $('#textareaBladeCreate').append("\{\!\! Form::submit('Create',['class'=>'btn btn-lg btn-success']); !!}\n\n\{\!\! Form::close() \!\!\}");

            $('#textareaBladeEdit').text(updateBlade);
            $('#textareaBladeEdit').append("\{\!\! Form::submit('Edit',['class'=>'btn btn-lg btn-success']); !!}\n\n\{\!\! Form::close() \!\!\}");


        });
    })
</script>
