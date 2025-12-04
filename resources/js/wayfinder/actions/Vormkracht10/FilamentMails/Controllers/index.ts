import MailPreviewController from './MailPreviewController'
import MailDownloadController from './MailDownloadController'

const Controllers = {
    MailPreviewController: Object.assign(MailPreviewController, MailPreviewController),
    MailDownloadController: Object.assign(MailDownloadController, MailDownloadController),
}

export default Controllers