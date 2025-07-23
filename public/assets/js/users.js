function initUsers() {
    return {
        data: [],
        editUserData: [],
        editProfile: false,
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
        editUser(id) {
            this.editUserData = { ...this.data.find(user => user.id === id) };
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
                            text: data.message,
                            icon: 'error',
                        });
                    }
                });
        }


    }
}