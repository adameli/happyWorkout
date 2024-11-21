let _state = {}


const STATE = {
    getEntity: (type) => {
        return JSON.parse(JSON.stringify(_state[type]))
    },

    fillState: async (token) => {
        try {
            const request = new Request('./api/POST.php?action=all', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ token })
            })

            const response = await fetcher(request)
            if (!response.ok) {
                console.log(response.statusText);
                return
            }

            const data = await response.json()

            console.log(data);

            for (const key in data) {
                _state[key] = data[key]
            }

            console.log(_state);



        } catch (error) {
            console.log('Error filling state', error);

        }
    }
}


async function fetcher(request) {
    try {
        let response = await fetch(request);
        return response;
    } catch (error) {
        console.log(error);
    }
}

export { STATE }