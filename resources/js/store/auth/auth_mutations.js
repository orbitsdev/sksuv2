


function array_has(arr, obj) {
    return arr.indexOf(obj) != -1;
}

function array_has_roles(arr, obj) {
    return arr.includes(obg);
}

export default {
    setUserDetails(state, payload) {
        state.Auth = payload;
    },

    setUser(state, payload) {
        const user_roles = [];
        payload.roles.forEach((role) => {
            user_roles.push(role.name);
        });

        state.User = {
            ...payload,
            user_roles: user_roles,
            token: localStorage.getItem('token'),
            is(role) {
                return array_has(state.User.user_roles, role);
            },
            hasRoles(roles) {
                return array_has_roles(state.User.user_roles, roles);
            },
        };
    },



};
