@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="clearfix">
                <span>Laravel jquery Ajax</span>
                
                <button type="button" class="btn btn-info float-right" onclick="create()">Add New</button>
            </div>
            <table class="table table-striped table-dark" id="table">
                <thead>
                  <tr>
                    <th scope="col">#id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
              
        </div>
    </div>

    <!-- Modal -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger" style="display:none"></div>
            <input type="hidden" name="id">
            <div class="form-group">
                <label>Name</label>
                <input class="form-control input-sm" type="text" name='name'>
            </div>

             <div class="form-group">
                <label>Email</label>
                <input class="form-control input-sm" type="text" name='email'>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input class="form-control input-sm" type="text" name='phone'>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary " id="btnSave" onclick="store()">Save</button>
          <button type="button" class="btn btn-primary " id ="btnUpdate" 
            onclick="update()">Update
          </button>
        </div>
      </div>
    </div>
  </div>


@endsection
@section('script')
<script>

    var _modal    = $("#modal");
    
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //     }
    // });

    function getContact(){
        $.get('http://127.0.0.1:8000'+'/contacts/data',data=>{
            console.log(data)
            var html='';
            console.log(data)
            data.forEach(row => {
                html +='<tr>'
                html +='<td>' + row.id + '</td>'
                html +='<td>' + row.name + '</td>'
                html +='<td>' + row.email + '</td>'
                html +='<td>' + row.phone + '</td>'
                html +='<td>'
                html += '<button type="button" class=" btnEdit btn btn-warning " id="btnEdit">Edit</button>'
                html += '<button type="button" class="btn btn-danger btnDelete " data-id="'+row.id+'">Delete</button>'
                html += '</td></tr>'
            });

            $('table tbody').html(html)    
        })
    }
    getContact()
    function getInputs() {
        var id    = $('input[name="id"]').val()
        var name  = $('input[name="name"]').val()
        var email = $('input[name="email"]').val()
        var phone = $('input[name="phone"]').val()

        return {id:id,name:name, email:email, phone:phone}
        
    }
    function reset(){
        $("#modal").find('input').each( function(){
            $(this).val(null)
        })
    }
    function create(){
        $('.alert-danger').hide()
        console.log("create function")
        $("#modal").find('.modal-title').text('New Text');
        reset();
        $("#modal").modal()
        $("#btnSave").show()
        $("#btnUpdate").hide()
    }
    function store() {
        if( !confirm('Are You sure ?')) return ;
        console.log(getInputs())
        $.ajax({
            method:'POST',
            url: 'http://127.0.0.1:8000'+'/contacts/store',
            data: getInputs(),
            dataType:'JSON',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: (data)=>{
                console.log('inserted')
                reset()
                $("#modal").modal('hide')
                getContact();
            },
            error: function(data){
                var errors = data.responseJSON.errors;

                var e =''
                $.each( errors , function( key, value ) {
                    
                     e+=value[0]+'</br>'
                    console.log(value[0])
                });
                console.log(e);
                $('.alert-danger').show()
                $('.alert-danger').html('<p>'+e+'</p>')
                
            }
        })
    }
    
    $(document).ready(()=>{
      $("table").on('click','.btnEdit',function(){
        console.log("click function")
        $("#modal").find('.modal-title').text('Edit Text');
        $("#modal").modal()
        $("#btnSave").hide()
        $("#btnUpdate").show()
        $('.alert-danger').hide()

        var id    = $(this).parent().parent().find('td').eq(0).text()
        var name  = $(this).parent().parent().find('td').eq(1).text()
        var email = $(this).parent().parent().find('td').eq(2).text()
        var phone = $(this).parent().parent().find('td').eq(3).text()

        $('input[name="id"]').val(id)
        $('input[name="name"]').val(name)
        $('input[name="email"]').val(email)
        $('input[name="phone"]').val(phone)
      });
    });

    function update() {
        if( !confirm('Are You sure Update?')) return ;
            
        console.log(getInputs())
        $.ajax({
            method:'POST',
            url: 'http://127.0.0.1:8000'+'/contacts/update',
            data: getInputs(),
            dataType:'JSON',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: ()=>{
                console.log('updated')
                reset()
                $("#modal").modal('hide')
                 getContact();
            },
        })
    }
    $(document).ready(()=>{
        $('table').on('click','.btnDelete',function(){
            console.log('deleted method')
            if(!confirm('Are you sure dlete this user ?')) return ;
            var id = $(this).data('id');
            console.log(id)
            var data={id:id}
            $.ajax({
                method:'POST',
                url:'http://127.0.0.1:8000'+'/contacts/delete',
                data:data,
                dataType:'JSON',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success:()=>{
                    console.log('deleted successfully')
                    getContact();
                }
            })
        })
    })
    
</script>
@endsection

