import ListPaymentGateways from './ListPaymentGateways'
import CreatePaymentGateway from './CreatePaymentGateway'
import EditPaymentGateway from './EditPaymentGateway'

const Pages = {
    ListPaymentGateways: Object.assign(ListPaymentGateways, ListPaymentGateways),
    CreatePaymentGateway: Object.assign(CreatePaymentGateway, CreatePaymentGateway),
    EditPaymentGateway: Object.assign(EditPaymentGateway, EditPaymentGateway),
}

export default Pages