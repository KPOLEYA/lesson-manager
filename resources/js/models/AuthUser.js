class AuthUser {

    constructor(data) {
        this.id = data.id;
        this.email = data.email;
        this.username = data.username;
        this.disabled_at = data.disabled_at;
        this.created_at = data.created_at;
        this.updated_at = data.updated_at;
        this.roles = data.roles;
        this.policies = data.policies;
    }

    hasRole(role) {
        return this.roles.some((item) => item.name === role);
    }

    hasPermission(permission) {
        return this.policies.includes(permission);
    }

    hasAllPermissions(...permissions) {
        return permissions.every(item => this.policies.includes(item));
    }

    hasAnyPermissions(...permissions) {
        return permissions.some(item => this.policies.includes(item));
    }

}

export default AuthUser
