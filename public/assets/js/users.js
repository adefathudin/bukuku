function initUsers() {
    return {
        data: [],
        editUserData: [],
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
        editUser(id) {
            this.editUserData = { ...this.data.find(user => user.id === id) };
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
                        this.init();
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