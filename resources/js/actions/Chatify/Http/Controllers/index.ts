import MessagesController from './MessagesController'
import Api from './Api'

const Controllers = {
    MessagesController: Object.assign(MessagesController, MessagesController),
    Api: Object.assign(Api, Api),
}

export default Controllers