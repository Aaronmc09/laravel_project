@extends('base')

@section('title', 'Contact Manager')
    
@section('content')

    <section class="main">
        <div class="container mt-4">
            <h1 class="text-center mb-4 p-4 text-secondary">Contact Lists</h1>
            <div class="row">
                @foreach ($contacts as $contact)

                <div class="card-columns">
                    <div class="card shadow border-0">
                        @if ($contact->image_path)
                            <img class="card-img-top" src="{{ $contact->image_path }}" alt="Card image cap" height="200">
                        @endif
                        
                        <div class="card-body">

                        <h5 class="card-title">{{ $contact->first_name }} {{ $contact->last_name }}
                            
                            <button class="btn btn-sm btn-info" id="{{ $contact->id }}" onclick="getContactData(this.id)">Edit</button>
                            <button class="btn btn-sm btn-danger" id="{{ $contact->id }}" onclick="deleteContactData(this.id)">Delete</button>

                        </h5>

                            <p class="card-text">Contact Number: {{ $contact->contact_number }}</p>

                            <p class="card-text">Address: {{ $contact->address }}</p>

                            <p class="card-text">E-mail: {{ $contact->email }}</p>

                            @if ($contact->note)

                                <p class="card-text">Note: {{ $contact->note }}</p>

                            @endif
                            
                            <p class="card-text"><small class="text-muted">{{ $contact->created_at->diffForHumans() }}</small></p>

                        </div>
                    </div>
                </div>
                                    
                @endforeach
            </div>
        </div>
    </section>

    <div class="button-container mx-auto my-5 w-25">

        <button class="btn btn-success btn-block" data-toggle="modal" data-target="#modalContactForm">Add Contact</button>

    </div>

    <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold">Contact Form</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body mx-3">
            <form action="/save" method="POST" enctype="multipart/form-data">
                <div class="md-form mb-2">
                    First name:
                    <input type="text" name="first_name" id="form34" required class="form-control">
                </div>

                <div class="md-form mb-2">
                    Last name:
                    <input type="text" name="last_name" id="last_name" required class="form-control">
                </div>

                <div class="md-form mb-2">
                    Contact number:
                    <input type="number" name="contact_number" id="contact_number" required class="form-control">
                </div>

                <div class="md-form mb-2">
                    Address:
                    <input type="text" name="address" id="address" required class="form-control">
                </div>

                <div class="md-form mb-2">
                    E-mail Address:
                    <input type="email" name="email" id="email" required class="form-control">
                </div>

                <div class="md-form mb-2">
                    Note:
                    <textarea type="text" name="note" id="note" class="md-textarea form-control" rows="4"></textarea>
                </div>

                <div class="md-form">
                    Avatar upload:<br>
                    <input type="file" name="image" id="image" accept="image/x-png,image/gif,image/jpeg" class="my-2">
                </div>

                {{ csrf_field() }}
                <button class="btn btn-block w-25 btn-success my-3 mx-auto" type="submit">Save</button>
            </form>
        </div>
    </div>
    </div>
    </div>

    <div class="modal fade" id="modalUpdateForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold">Contact Update Form</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body mx-3">
            <form action="/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="update_id">
                <div class="md-form mb-2">
                    First name:
                    <input type="text" name="first_name" id="update_fn" required class="form-control">
                </div>

                <div class="md-form mb-2">
                    Last name:
                    <input type="text" name="last_name" id="update_ln" required class="form-control">
                </div>

                <div class="md-form mb-2">
                    Contact number:
                    <input type="number" name="contact_number" id="update_cn" required class="form-control">
                </div>

                <div class="md-form mb-2">
                    Address:
                    <input type="text" name="address" id="update_ad" required class="form-control">
                </div>

                <div class="md-form mb-2">
                    E-mail Address:
                    <input type="email" name="email" id="update_em" required class="form-control">
                </div>

                <div class="md-form mb-2">
                    Note:
                    <textarea type="text" name="note" id="update_no" class="md-textarea form-control" rows="4"></textarea>
                </div>

                <div class="md-form">
                    Avatar upload:<br>
                    <input type="file" name="image" id="update_im" accept="image/x-png,image/gif,image/jpeg" class="my-2">
                </div>

                {{ csrf_field() }}

                <button class="btn btn-block w-50 btn-success my-3 mx-auto" type="submit">Save Changes</button>
            </form>
        </div>
    </div>
    </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>
        function getContactData(contact_id) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'GET',
                url:'/update',
                data: {_token: CSRF_TOKEN, id:contact_id },
                dataType: 'JSON',
                success:function(data) {
                    document.getElementById('update_id').value = data.data.id;
                    document.getElementById('update_fn').value = data.data.first_name;
                    document.getElementById('update_ln').value = data.data.last_name;
                    document.getElementById('update_cn').value = data.data.contact_number;
                    document.getElementById('update_ad').value = data.data.address;
                    document.getElementById('update_em').value = data.data.email;
                    document.getElementById('update_no').value = data.data.note;

                    $('#modalUpdateForm').modal('show');
                }
            });
        }
        function deleteContactData(contact_id) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'GET',
                url:'/delete',
                data: {_token: CSRF_TOKEN, id:contact_id },
                dataType: 'JSON',
                success:function(data) {
                    if(data.success) {
                        location.href = "/";
                    }
                }
            });
        }
     </script>

@endsection