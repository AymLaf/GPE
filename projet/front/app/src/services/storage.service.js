const StorageService = {
    has(key) {
        return localStorage.getItem(key) !== null;
    },
    get(key) {
        let value = localStorage.getItem(key);
        try {
            let o = JSON.parse(value);
            if(typeof o === 'object' || value instanceof Array){
                return o;
            }
        } catch (e) {
            console.log("Problem");
        }

        return value ? value : false;
    },
    set(key, value) {
        if (typeof value === 'object' || value instanceof Array) {
            value = JSON.stringify(value)
        }
        localStorage.setItem(key, value)

    },
    remove(key) {
        if (typeof localStorage.getItem(key) !== 'undefined') {
            localStorage.removeItem(key);
        }
    }
};

export default StorageService
