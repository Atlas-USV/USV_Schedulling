@extends('layouts.app')

@section('title', 'Invitation list')
@section('content')

<head>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
</head>
<form method="GET" action="{{ route('invitation') }}">
    <button 
        type="submit" 
        id="create-invitation" 
        class="mb-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Invită
    </button>
</form>

<table id="filter-table">
   
</table>

<script>
    function resendInvitation(id) {
        $.ajax({
            url: `/invitations/${id}/resend`,
            type: 'GET',
            success: function (response) {
                toastr.success('Invitație retrimisă cu succes');
            }
        });
    }
if (document.getElementById("filter-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    console.log(@json($invitations))
    const tableData = (@json($invitations)).map((i)=>[
        i.email,
        i.role?.name ?? "",
        i.group?.name ?? "",
        i.faculty?.short_name ?? "",
        i.speciality?.short_name ?? "",
        i.expires_at,
        // i.id,
         `<button onclick="resendInvitation('${i.id}')" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Retrimite</button>`
    ])

    
    const dataTable = new simpleDatatables.DataTable("#filter-table", {
        data: {
            headings: ["Email", "Rol", "Grupa","Facultate", "Specialitate", "Expira la", "Action"],
            data: tableData
         },
        tableRender: (_data, table, type) => {
            if (type === "print") {
                return table
            }
            const tHead = table.childNodes[0]
            const filterHeaders = {
                nodeName: "TR",
                attributes: {
                    class: "search-filtering-row"
                },
                childNodes: tHead.childNodes[0].childNodes.map(
                    (_th, index) => ({nodeName: "TH",
                        childNodes: index < 6 ? [ // Only add search input for first 6 columns
                            {
                                nodeName: "INPUT",
                                attributes: {
                                    class: "datatable-input",
                                    type: "search",
                                    "data-columns": "[" + index + "]"
                                }
                            }
                        ] : [] // Empty array for last column
                    })
                )
            }

            tHead.childNodes.push(filterHeaders)
            return table
        }
    });
}

</script>

@endsection