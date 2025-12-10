import ActivityLogController from './ActivityLogController'
import ExportController from './ExportController'

const Controllers = {
    ActivityLogController: Object.assign(ActivityLogController, ActivityLogController),
    ExportController: Object.assign(ExportController, ExportController),
}

export default Controllers