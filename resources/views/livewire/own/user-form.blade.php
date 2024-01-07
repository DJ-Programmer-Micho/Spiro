
<div>
<!-- Image Crop -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.5/cropper.min.js"></script>
{{-- inline style for modal --}}
<style>
    .image_area { position: relative; }
    img { display: block; max-width: 100%; }
    .preview { overflow: hidden; width: 160px;  height: 160px; margin: 10px; border: 1px solid red;}
    .modal-lg{max-width: 1000px !important;}
    .overlay { position: absolute; bottom: 10px; left: 0; right: 0; background-color: rgba(255, 255, 255, 0.5); overflow: hidden; height: 0; transition: .5s ease; width: 100%;}
    .image_area:hover .overlay { height: 50%; cursor: pointer; }
    .text { color: #333; font-size: 20px; position: absolute; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%); text-align: center;}
    .switch input { display:none; }
    .switch { display:inline-block; width:60px; height:20px; margin:8px; position:relative; }
    .slider { position:absolute; top:0; bottom:0; left:0; right:0; border-radius:30px; box-shadow:0 0 0 2px #cc0022, 0 0 4px #cc0022; cursor:pointer; border:4px solid transparent; overflow:hidden; transition:.4s; }
    .slider:before { position:absolute; content:""; width:100%; height:100%; background:#cc0022; border-radius:30px; transform:translateX(-30px); transition:.4s; }
    input:checked + .slider:before { transform:translateX(30px); background:limeGreen; }
    input:checked + .slider { box-shadow:0 0 0 2px limeGreen,0 0 2px limeGreen; }
</style>

    <!-- Insert Modal  -->
    <div wire:ignore.self class="modal fade overflow-auto" id="createUserModal" tabindex="-1" aria-labelledby="createUserModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="addUser">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createUserModal" style="color: #31fbe2">{{__('Add User')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Initialize Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="name">{{__('Full Name:')}}</label>
                                    <input type="text" name="name" wire:model="name" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email">{{__('Email To Sign In:')}}</label>
                                    <input type="email" name="email" wire:model="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password">{{__('Password:')}}</label>
                                    <input type="text" name="password" wire:model="password" class="form-control" id="password" required>
                                </div>
                                <div class="mb-3">
                                    <label>{{__('Role')}}</label>
                                    <select wire:model="role" name="role" id="role" class="form-control" required>
                                        <option value="">{{__('Choose Role')}}</option>
                                            <option value="1">{{__('Admin')}}</option>
                                            <option value="2">{{__('Editor')}}</option>
                                            <option value="3">{{__('Finance')}}</option>
                                            <option value="4">{{__('Employee')}}</option>
                                    </select>
                                </div>
                                <label>{{__('Status')}}</label>
                                <select wire:model="status" name="status" id="status" class="form-control" required>
                                    <option value="">{{__('Choose Status')}}</option>
                                        <option value="1">{{__('Active')}}</option>
                                        <option value="0">{{__('Non Active')}}</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h2 class="text-lg font-medium text-center">
                                    <b class="text-uppercase text-white">{{__('Upload Avatar Image')}}</b>
                                </h2>
                                <label for="img">{{__('Upload Image')}}</label>
                                <input type="file" name="avatarImg" id="avatarImg" class="form-control" style="height: auto">
                                <small class="bg-info text-white px-2 rounded">{{__('The Image Size Should be')}} <b>{{__('(640px X 640px)')}}</b></small>
                                @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                                <input type="file" name="croppedAvatarImg" id="croppedAvatarImg" style="display: none;">
                                <div class="progress my-1">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated fImg" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <div class="mb-3 d-flex justify-content-center mt-1">
                                    <img id="showAvatarImg" class="img-thumbnail rounded" src="{{ $temp_avatarImg ?? $default_avatarImg }}" width="200px">
                                </div>
                            </div>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Secondary Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="jobTitle">{{__('Job Title:')}}</label>
                                    <input type="text" name="jobTitle" wire:model="jobTitle" class="form-control" id="jobTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nationalId">{{__('National ID:')}}</label>
                                    <input type="text" name="nationalId" wire:model="nationalId" class="form-control" id="nationalId" required>
                                </div>
                                <div class="mb-3">
                                    <label for="actualEmail">{{__('Owner Email Address:')}}</label>
                                    <input type="email" name="actualEmail" wire:model="actualEmail" class="form-control" id="actualEmail">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="phoneNumberOne">{{__('First Phone Number:')}}</label>
                                    <input type="tel" name="phoneNumberOne" wire:model="phoneNumberOne" class="form-control" id="phoneNumberOne" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phoneNumberTwo">{{__('Second Phone Number:')}}</label>
                                    <input type="tel" name="phoneNumberTwo" wire:model="phoneNumberTwo" class="form-control" id="phoneNumberTwo">
                                </div>
                                <div class="mb-3">
                                    <label for="salaryDollar">{{__('Salary in ($):')}}</label>
                                    <input type="number" name="salaryDollar" wire:model="salaryDollar" class="form-control" id="salaryDollar" required>
                                </div>
                                <div class="mb-3">
                                    <label for="salaryIraqi">{{__('Salary in (IQD):')}}</label>
                                    <input type="number" name="salaryIraqi" wire:model="salaryIraqi" class="form-control" id="salaryIraqi" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-success submitJs">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <div wire:ignore.self class="modal fade overflow-auto" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl text-white mx-1 mx-lg-auto" style="max-width: 1140px;">
            <div class="modal-content bg-dark">
                <form wire:submit.prevent="updateUser">
                    <div class="modal-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createUserModal" style="color: #31fbe2">{{__('Add User')}}</h5>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Initialize Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="name">{{__('Full Name:')}}</label>
                                    <input type="text" name="name" wire:model="name" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email">{{__('Email To Sign In:')}}</label>
                                    <input type="email" name="email" wire:model="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password">{{__('Password:')}}</label>
                                    <input type="text" name="password" wire:model="password" class="form-control" id="password" required>
                                </div>
                                <div class="mb-3">
                                    <label>{{__('Role')}}</label>
                                    <select wire:model="role" name="role" id="role" class="form-control" required>
                                        <option value="">{{__('Choose Role')}}</option>
                                            <option value="1">{{__('Admin')}}</option>
                                            <option value="2">{{__('Editor')}}</option>
                                            <option value="3">{{__('Finance')}}</option>
                                            <option value="4">{{__('Employee')}}</option>
                                    </select>
                                </div>
                                <label>{{__('Status')}}</label>
                                <select wire:model="status" name="status" id="status" class="form-control" required>
                                    <option value="">{{__('Choose Status')}}</option>
                                        <option value="1">{{__('Active')}}</option>
                                        <option value="0">{{__('Non Active')}}</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h2 class="text-lg font-medium text-center">
                                    <b class="text-uppercase text-white">{{__('Upload Avatar Image')}}</b>
                                </h2>
                                <label for="img">{{__('Upload Image')}}</label>
                                <input type="file" name="editAvatarImg" id="editAvatarImg" class="form-control" style="height: auto">
                                <small class="bg-info text-white px-2 rounded">{{__('The Image Size Should be')}} <b>{{__('(640px X 640px)')}}</b></small>
                                @error('objectName') <span class="text-danger">{{ $message }}</span> @enderror
                                <input type="file" name="editCroppedAvatarImg" id="editCroppedAvatarImg" style="display: none;">
                                <div class="progress my-1">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated fImg" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <div class="mb-3 d-flex justify-content-center mt-1">
                                    <img id="editShowAvatarImg" class="img-thumbnail rounded" src="{{ $temp_avatarImg ?? $default_avatarImg }}" width="200px">
                                </div>
                            </div>
                        </div>
                        <h5 class="mt-4 mb-1"><b>{{__('Secondary Information')}}</b></h5>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="jobTitle">{{__('Job Title:')}}</label>
                                    <input type="text" name="jobTitle" wire:model="jobTitle" class="form-control" id="jobTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nationalId">{{__('National ID:')}}</label>
                                    <input type="text" name="nationalId" wire:model="nationalId" class="form-control" id="nationalId" required>
                                </div>
                                <div class="mb-3">
                                    <label for="actualEmail">{{__('Owner Email Address:')}}</label>
                                    <input type="email" name="actualEmail" wire:model="actualEmail" class="form-control" id="actualEmail">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <label for="phoneNumberOne">{{__('First Phone Number:')}}</label>
                                    <input type="tel" name="phoneNumberOne" wire:model="phoneNumberOne" class="form-control" id="phoneNumberOne" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phoneNumberTwo">{{__('Second Phone Number:')}}</label>
                                    <input type="tel" name="phoneNumberTwo" wire:model="phoneNumberTwo" class="form-control" id="phoneNumberTwo">
                                </div>
                                <div class="mb-3">
                                    <label for="salaryDollar">{{__('Salary in ($):')}}</label>
                                    <input type="number" name="salaryDollar" wire:model="salaryDollar" class="form-control" id="salaryDollar" required>
                                </div>
                                <div class="mb-3">
                                    <label for="salaryIraqi">{{__('Salary in (IQD):')}}</label>
                                    <input type="number" name="salaryIraqi" wire:model="salaryIraqi" class="form-control" id="salaryIraqi" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success submitJs">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     
    <div wire:ignore.self class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog text-white">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteFoodModalLabel">{{__('Delete User')}}</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form wire:submit.prevent="destroyUser">
                    <div class="modal-body">
                        <p>{{ __('Are you sure you want to delete this User?') }}</p>
                        <p>{{ __('Please enter the')}}<strong> "{{$del_user_name}}" </strong>{{__('to confirm:') }}</p>
                        <input type="text" wire:model="user_name_to_selete" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-dismiss="modal">{{__('Cancel')}}</button>
                            <button type="submit" class="btn btn-danger" wire:disabled="!confirmDelete || $foodNameToDelete !== $showTextTemp">
                                {{ __('Yes! Delete') }}
                            </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    {{-- IMAGE CROP MODAL --}}
    <div class="modal fade" id="modal" tabindex="-2" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg text-white" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Crop Image Before Upload')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="" id="sample_image" />
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" id="crop" class="btn btn-primary">Crop</button> --}}
                    <button type="button" class="btn btn-primary crop-btn" data-index="">{{__('Crop')}}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
                </div>
            </div>
        </div>
    </div> 

</div>

@push('cropper')
{{-- Add --}}
<script>
    document.addEventListener('livewire:load', function () {
        var modal = new bootstrap.Modal(document.getElementById('modal'));
        var cropper;
    
        $('#avatarImg').change(function (event) {
            var image = document.getElementById('sample_image');
            var files = event.target.files;
            var done = function (url) {
                image.src = url;
                modal.show();
            };
            if (files && files.length > 0) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
            handleCropButtonClick(image);
        });
    
        function handleCropButtonClick(image) {
            $('#modal').on('shown.bs.modal', function () {
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 640 / 640,
                    viewMode: 1,
                    preview: '.preview'
                });
            });
    
            $('.crop-btn').off('click').on('click', function () {
                var canvas = cropper.getCroppedCanvas({
                    width: 640,
                    height: 640
                });
    
                canvas.toBlob(function (blob) {
                    var url = URL.createObjectURL(blob);
    

                    // Livewire.emit('updateCroppedavatarImg', data);
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        modal.hide();
                        // $('#showavatarImg').attr('src', base64data);
                        // Livewire.emit('updateCroppedAvatarImg', base64data); // Emit Livewire event
                        Livewire.emit('updateCroppedAvatarImg', base64data); // Emit Livewire event

                        if (cropper) {
                            cropper.destroy();
                            document.getElementById('avatarImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);
    
                    var file = new File([blob], 'met_about.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('croppedAvatarImg');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
    
                    modal.hide();
                }, 'image/jpeg');
            });
        }
    });
</script>
{{-- Edit --}}
<script>
    document.addEventListener('livewire:load', function () {
        var modal = new bootstrap.Modal(document.getElementById('modal'));
        var cropper;
    
        $('#editAvatarImg').change(function (event) {
            var image = document.getElementById('sample_image');
            var files = event.target.files;
            var done = function (url) {
                image.src = url;
                modal.show();
            };
            if (files && files.length > 0) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
            handleCropButtonClick(image);
        });
    
        function handleCropButtonClick(image) {
            $('#modal').on('shown.bs.modal', function () {
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 640 / 640,
                    viewMode: 1,
                    preview: '.preview'
                });
            });
    
            $('.crop-btn').off('click').on('click', function () {
                var canvas = cropper.getCroppedCanvas({
                    width: 640,
                    height: 640
                });
    
                canvas.toBlob(function (blob) {
                    var url = URL.createObjectURL(blob);
    

                    // Livewire.emit('updateCroppedFoodImg', data);
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        modal.hide();
                        // $('#showEditFoodImg').attr('src', base64data);
                        Livewire.emit('updateCroppedAvatarImg', base64data); // Emit Livewire event

                        if (cropper) {
                            cropper.destroy();
                            document.getElementById('editCroppedAvatarImg').value = null;
                        }
                    };
                    reader.readAsDataURL(blob);
    
                    var file = new File([blob], 'met.jpg', { type: 'image/jpeg' });
                    var fileInput = document.getElementById('editCroppedAvatarImg');
                    var dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
    
                    modal.hide();
                }, 'image/jpeg');
            });
        }
    });
</script>
<script>
    window.addEventListener('fakeProgressBarFood', (e) => {
    document.querySelector('.submitJs').disabled = true;
    let currentProgress = 0;
            const progressBar = document.querySelector('.fImg');
            // const increment = 50; // Increase this value to control the simulation speed
            var randomIncrement = 0;
            const interval = setInterval(function () {
                randomIncrement = Math.floor(Math.random() * (50 - 10 + 1)) + 10;
                currentProgress += randomIncrement;
                if (currentProgress <= 100) {
                    progressBar.style.width = currentProgress + '%';
                    progressBar.setAttribute('aria-valuenow', currentProgress);
                } else {
                        // Notify Livewire when the simulation is complete
                    clearInterval(interval);
                    progressBar.style.width = '100%';
                    if(currentProgress >= 100){
                        Livewire.emit('simulationCompleteImgFood');
                        currentProgress = 0;
                        document.querySelector('.submitJs').disabled = false;
                    }
                    progressBar.setAttribute('aria-valuenow', '0');
                }
            }, 1000); // Adjust the interval timing as needed
    });
    window.addEventListener('fakeProgressBarFood', (e) => {
    document.querySelector('.submitJs').disabled = true;
    let currentProgress = 0;
            const progressBar = document.querySelector('.fImgEdit');
            // const increment = 50; // Increase this value to control the simulation speed
            var randomIncrement = 0;
            const interval = setInterval(function () {
                randomIncrement = Math.floor(Math.random() * (50 - 10 + 1)) + 10;
                currentProgress += randomIncrement;
                if (currentProgress <= 100) {
                    progressBar.style.width = currentProgress + '%';
                    progressBar.setAttribute('aria-valuenow', currentProgress);
                } else {
                        // Notify Livewire when the simulation is complete
                    clearInterval(interval);
                    progressBar.style.width = '100%';
                    if(currentProgress >= 100){
                        Livewire.emit('simulationCompleteImgFood');
                        currentProgress = 0;
                        document.querySelector('.submitJs').disabled = false;
                    }
                    progressBar.setAttribute('aria-valuenow', '0');
                }
            }, 1000); // Adjust the interval timing as needed
    });
</script>
@endpush