<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel 5.8 - DataTables Server Side Processing using Ajax</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
 <body>

  <div class="container">
     <br/>
            <h3 align="center">ค้นหาข้อมูลเกี่ยวกลับพระพุทธศาสนา</h3>
            <h3 align="center">ผู้เข้าชมระบบยืมคืนอุปกรณ์ทางศาสนพิธีกรณีศึกษาชมรมพุทธธรรมกรรมฐาน สามารถเพิ่มความรู้ของพระพุทธศานนาได้</h3>
     <br/>

     <div align="right">
            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm-8">เพิ่มข้อมูล</button>
     </div>
     <br/>

    <div class="table-responsive">
    <table class="table table-bordered table-striped" id="user_table">
           <thead>
            <tr>
                <th width="15%">รูป</th>
                <th width="20%">ชื่อเรื่อง</th>
                <th width="40%">คำอธิบาย</th>
                <th width="40%">หมายเหตุ</th>
                <th width="50%">จัดการข้อมูล</th>
            </tr>
           </thead>
       </table>
   </div>
<br/>
<br/>
</div>
</body>
</html>

<div id="formModal" class="modal fade" role="dialog" >
 <div class="modal-dialog ">
  <div class="modal-content">
   <div class="modal-header">
          <button type="button" class="close " data-dismiss="modal">&times;</button>
          <h4 class="modal-title" >เพิ่มข้อมูล</h4>
        </div>
        <div class="modal-body">
         <span id="form_result"></span>
         <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4" >ชื่อเรื่อง : </label>
            <div class="col-md-8">
             <input type="text" name="first_name" id="first_name" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">คำอธิบาย : </label>
            <div class="col-md-8">
             <input type="text" name="last_name" id="last_name" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">หมายเหตุ : </label>
            <div class="col-md-8">
             <input type="text" name="name" id="name" class="form-control" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">รูปภาพประกอบ: </label>
            <div class="col-md-8">
             <input type="file" name="image" id="image" />
             <span id="store_image"></span>
            </div>
           </div>
           <br />
           <div class="form-group" align="center">
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
           </div>
         </form>
        </div>
     </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">ลบข้อมูล</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">คุณแน่ใจหรือว่าต้องการลบข้อมูลนี้?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">ตกลง</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
        </div>
    </div>
</div>


  <script>
        $(document).ready(function(){

         $('#user_table').DataTable({
                processing: true,
                serverSide: true,
          ajax:{
           url: "{{route('ajax-crud.index') }}",
               },
          columns:[
           {
                data: 'image',
                name: 'image',
            render: function(data, type, full, meta){
             return "<img src={{ URL::to('/') }}/images/" + data + " width='100' class='img-thumbnail' />";
            },
            orderable: false
           },
           {
            data: 'first_name',
            name: 'first_name'
           },
           {
            data: 'last_name',
            name: 'last_name'
           },
           {
            data: 'name',
            name: 'name'
           },
           {
            data: 'action',
            name: 'action',
            orderable: false
           }
          ]
         });

         $('#create_record').click(function(){
          $('.modal-title').text("เพิ่มข้อมูล");
             $('#action_button').val("บันทึกข้อมูล");
             $('#action').val("Add");
             $('#formModal').modal('show');
         });

         $('#sample_form').on('submit', function(event){
          event.preventDefault();
          if($('#action').val() == 'Add')
          {
           $.ajax({
            url:"{{ route('ajax-crud.store') }}",
            method:"POST",
            data: new FormData(this),
            contentType: false,
            cache:false,
            processData: false,
            dataType:"json",
            success:function(data)
            {
             var html = '';
             if(data.errors)
             {
              html = '<div class="alert alert-danger">';
              for(var count = 0; count < data.errors.length; count++)
              {
               html += '<p>' + data.errors[count] + '</p>';
              }
              html += '</div>';
             }
             if(data.success)
             {
              html = '<div class="alert alert-success">' + data.success + '</div>';
              $('#sample_form')[0].reset();
              $('#user_table').DataTable().ajax.reload();
             }
             $('#form_result').html(html);
            }
           })
          }

          if($('#action').val() == "Edit")
          {
           $.ajax({
            url:"{{ route('ajax-crud.update') }}",
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType:"json",
            success:function(data)
            {
             var html = '';
             if(data.errors)
             {
              html = '<div class="alert alert-danger">';
              for(var count = 0; count < data.errors.length; count++)
              {
               html += '<p>' + data.errors[count] + '</p>';
              }
              html += '</div>';
             }
             if(data.success)
             {
              html = '<div class="alert alert-success">' + data.success + '</div>';
              $('#sample_form')[0].reset();
              $('#store_image').html('');
              $('#user_table').DataTable().ajax.reload();
             }
             $('#form_result').html(html);
            }
           });
          }
         });

                   $(document).on('click', '.edit', function(){
                    var id = $(this).attr('id');
                    $('#form_result').html('');
                    $.ajax({
                     url:"/ajax-crud/"+id+"/edit",
                     dataType:"json",
                     success:function(html){
                      $('#first_name').val(html.data.first_name);
                      $('#last_name').val(html.data.last_name);
                      $('#name').val(html.data.name);
                      $('#store_image').html("<img src={{ URL::to('/') }}/images/" + html.data.image + " width='100' class='img-thumbnail' />");
                      $('#store_image').append("<input type='hidden' name='hidden_image' value='"+html.data.image+"' />");
                      $('#hidden_id').val(html.data.id);
                      $('.modal-title').text("แก้ไขข้อมูล");
                      $('#action_button').val("บันทึกการแก้ไขข้อมูล");
                      $('#action').val("Edit");
                      $('#formModal').modal('show');
           }
          })
         });

         var user_id;

         $(document).on('click', '.delete', function(){
          user_id = $(this).attr('id');
          $('#confirmModal').modal('show');
         });

         $('#ok_button').click(function(){
          $.ajax({
           url:"ajax-crud/destroy/"+user_id,
           beforeSend:function(){
            $('#ok_button').text('Deleting...');
           },
           success:function(data)
           {
            setTimeout(function(){
             $('#confirmModal').modal('hide');
             $('#user_table').DataTable().ajax.reload();
            }, 2000);
           }
          })
         });

        });
</script>
