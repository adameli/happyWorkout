import { PubSub } from '../../../logic/pubsub.js'
import { STATE } from '../../../logic/state.js';

PubSub.subscribe({ event: 'renderHome', listener: renderHomeContent })


function renderHomeContent() {
    const app = document.getElementById('app')

    const username = STATE.getEntity('username')

    // Empty the app div
    app.innerHTML = ''

    // Fill the app div with containers
    app.innerHTML = `
        <div id="home-wrapper" class="wrapper">
            <div id="user-info" class="container">
                <h2>Hello ${username} let's workout</h2>
            </div>
            <div id="workouts" class="container">
                <h2>Workouts</h2>
            </div>
            <div id="progress" class="container">
                <h2>Progress</h2>
            </div>
        </div>
    `

    PubSub.publish({ event: 'renderHomeContent' })
}