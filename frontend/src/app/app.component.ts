import { Component, Input } from '@angular/core';
import { DetailComponent } from './detail/detail.component';
import { trigger, transition, style, animate, query, group } from '@angular/animations';
import { RouterOutlet } from '@angular/router';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss'],
  animations: [
    trigger('routeAnimations', [
      transition('* <=> *', [
        query(':enter, :leave', style({ position: 'absolute', width: '100%' }), { optional: true }),
        group([
          query(':enter', [
            style({ opacity: 0 }),
            animate('2000ms ease', style({ opacity: 1 }))
          ], { optional: true }),
          query(':leave', [
            style({ opacity: 1 }),
            animate('2000ms ease', style({ opacity: 0 }))
          ], { optional: true })
        ])
      ])
    ])
  ]
})
export class AppComponent {

  selectedEducator: { name: string, email: string } | null = null;

  prepareRoute(outlet: RouterOutlet) {
    return outlet && outlet.activatedRouteData && outlet.activatedRouteData['animation'];
  }

/*   onActivate(event: any) {
    if (event instanceof DetailComponent) {
      this.selectedEducator = event.educator ? { name: event.educator.name, email: event.educator.email } : null;
    } else {
      this.selectedEducator = null;
    }
  } */

  title = 'PortalEducadores';
}
