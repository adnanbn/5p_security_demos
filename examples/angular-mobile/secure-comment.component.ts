import { Component, Input } from '@angular/core'

@Component({
  selector: 'app-comment',
  standalone: true,
  template: '<p>{{ body }}</p>',
})
export class SecureCommentComponent {
  // Angular escapes interpolation. Do not bypass trust for untrusted content.
  @Input({ required: true }) body = ''
}
