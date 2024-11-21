import { PubSub } from '../../logic/pubsub.js'
import { STATE } from '../../logic/state.js'

PubSub.subscribe({ event: 'renderHomeContent', listener: createWorkoutInstance })

function createWorkoutInstance() {
    const parent = document.getElementById('workouts')
    const workouts = STATE.getEntity('workouts')


    let createWorkoutBtn = document.createElement('button');
    createWorkoutBtn.textContent = "Create Workout";
    createWorkoutBtn.id = 'create-workout-btn';
    createWorkoutBtn.addEventListener('click', () => {
        PubSub.publish({ event: 'createWorkout', detail: null });
    })
    parent.appendChild(createWorkoutBtn);




}