import HealthCheckResultsController from './HealthCheckResultsController'
import HealthCheckJsonResultsController from './HealthCheckJsonResultsController'

const Controllers = {
    HealthCheckResultsController: Object.assign(HealthCheckResultsController, HealthCheckResultsController),
    HealthCheckJsonResultsController: Object.assign(HealthCheckJsonResultsController, HealthCheckJsonResultsController),
}

export default Controllers