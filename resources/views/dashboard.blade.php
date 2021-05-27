<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div style="margin: 20px;">
        <div class="card">
            <div class="card-body">
                <table id="user_table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Salary</th>
                            <th>Department</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Salary</th>
                            <th>Department</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
<script type="text/javascript">
    $(document).ready(function(){
        get_rec();
    });

    function get_rec()
    {
        $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dashboard.getData') }}"
            },
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ -1 ] }, 
                { "bSearchable": false, "aTargets": [ -1 ] }
            ],
            columnDefs: [
                {
                    targets: -1,
                    className: 'dt-body-right'
                }
            ],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'salary',
                    name: 'salary'
                },
                {
                    data: 'department',
                    name: 'department'
                },
                {
                    data: 'action',
                    name: 'action',
                }
            ]
        });
    }

    function delete_rec(id)
    {
        swal({
            title: "Delete Employee",
            text: "Are you sure want to delete this Employee?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url:'{{ route('dashboard.deleteData') }}',
                    data:{id:id,_token:'{{ csrf_token() }}'},
                    type:'POST',
                    success:function(resp) {
                        if (resp) {
                            swal({
                                title: "Employee",
                                text: "Employee has been deleted successfully!",
                                icon: "success",
                            });
                            table = $('#user_table').DataTable();
                            table.destroy();
                            get_rec();
                        }
                    }
                });
            } else {
                swal({
                    title: "Employee",
                    text: "You have cancelled deletion of Employee!",
                    icon: "error",
                });
            }
        });
    }
</script>