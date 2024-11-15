import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Educator } from '../interfaces/Educator';
import { EducatorsService } from '../services/educators.service';

@Component({
  selector: 'app-detail',
  templateUrl: './detail.component.html',
  styleUrls: ['./detail.component.scss']
})

export class DetailComponent implements OnInit {

  educator: Educator | undefined;
  currentImageIndex = 0;

  constructor(
    private route: ActivatedRoute,
    private educatorsService: EducatorsService
  ) { }

  ngOnInit(): void {
    const name = this.route.snapshot.paramMap.get('name') || '';
    this.educatorsService.getEducatorByName(name).subscribe(educator => this.educator = educator);
    this.startImageCarousel();
  }

  startImageCarousel() {
    setInterval(() => {
      this.currentImageIndex = (this.currentImageIndex + 1) % this.educator!.optionalPics!.length;
    }, 3000); // Cambia la imagen cada 3 segundos
  }

}
