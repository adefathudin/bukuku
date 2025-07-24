function initUsers() {
    return {
        data: [],
        editUserData: [],
        editProfile: false,
        showForm: false,
        editButton: false,
        deleteButton: false,
        formTitle: 'Add User',
        async init() {
            const response = await fetch(`/api/users`, {
                method: 'GET',
                credentials: 'include',
                headers: {
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            this.data = result;
        },

        async userDetails() {
            const response = await fetch(`/api/users/detail`, {
                method: 'GET',
                credentials: 'include',
                headers: {
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            if (result.success) {
                this.editUserData = result.data;
            } else {
                Swal.fire({
                    title: 'Error',
                    text: result.message,
                    icon: 'error',
                });
            }
        },
        selectUser(id) {

            if (id === this.editUserData.id) {
                this.editUserData = [];
                this.editButton = false;
                this.deleteButton = false;
                return;
            }

            this.editUserData = { ...this.data.find(user => user.id === id) };
            this.showForm = false;
            this.editButton = true;
            this.deleteButton = true;
        },

        updateProfile() {
            this.editProfile = true;
            this.submitForm();
        },

        submitForm() {
            const formData = new FormData();
            formData.append('id', this.editUserData.id);
            formData.append('name', this.editUserData.name);
            formData.append('email', this.editUserData.email);
            formData.append('role', this.editUserData.role);
            formData.append('active', this.editUserData.active);
            formData.append('password', this.editUserData.password);

            fetch(`/api/users/save`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success',
                            text: 'User updated successfully',
                            icon: 'success',
                        })
                        this.editUserData = [];
                        if (!this.editProfile) {
                            this.init();
                        } else {
                            this.userDetails();
                        }
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.error,
                            icon: 'error',
                        });
                    }
                });
        },

        addUser() {
            this.editUserData = {
                id: null,
                name: '',
                email: '',
                role: 'user',
                active: 'Y',
                password: ''
            };
            this.showForm = true;
            this.formTitle = 'Add User';
            this._validateUserData();
        },

        editUser() {
            this._validateUserData();
            if (this.editUserData.id) {
                this.showForm = true;
                this.formTitle = 'Edit User';
            }
        },

        deleteUser() {
            this._validateUserData();
            if (this.editUserData.id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/api/users/delete/${this.editUserData.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrf_token
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'User has been deleted.',
                                        'success'
                                    );
                                    this.init();
                                    this.editUserData = [];
                                    this._validateUserData();
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: data.message,
                                        icon: 'error',
                                    });
                                }
                            });
                    }
                });
            }
        },

        _validateUserData() {
            if (!this.editUserData.id) {
                this.editButton = false;
                this.deleteButton = false;
            } else {
                this.editButton = true;
                this.deleteButton = true;
            }

        }

    }
}