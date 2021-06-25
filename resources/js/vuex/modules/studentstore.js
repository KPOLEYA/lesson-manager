const state = {
    views: {
        index: {
            pagination: {
                page: 1
            },
            filters: {
                name: null,
                level: null,
                status: null,
            }
        },
    },
}

const actions = {
    index (context, params) {
        return new Promise((resolve, reject) => {
            axios
                .get(route('students.index',  {...params} ))
                .then((response) => {
                    resolve(response);
                })
                .catch((err)=>{
                    console.error(err);
                    reject(err);
                })
        })
    },
}

export default {
    namespaced: true,
    state,
    actions,
}



