import RequestAnalyticsController from './RequestAnalyticsController'
import Api from './Api'

const Controllers = {
    RequestAnalyticsController: Object.assign(RequestAnalyticsController, RequestAnalyticsController),
    Api: Object.assign(Api, Api),
}

export default Controllers