import Health from './Health'
import LaravelIgnition from './LaravelIgnition'
import Prometheus from './Prometheus'

const Spatie = {
    Health: Object.assign(Health, Health),
    LaravelIgnition: Object.assign(LaravelIgnition, LaravelIgnition),
    Prometheus: Object.assign(Prometheus, Prometheus),
}

export default Spatie