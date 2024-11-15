import { Component, OnInit } from '@angular/core';
import { Educator } from '../interfaces/Educator';
import { EducatorsService } from '../services/educators.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-list',
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss']
})
export class ListComponent implements OnInit {

  educators: Educator[] = [];
  searchTerm: string = '';
  filteredEducators: Educator[] = [];

  constructor(private educatorsService: EducatorsService, private router: Router){}
  
  ngOnInit(): void {
    this.educatorsService.getEducatorsList().subscribe((data: Educator[]) => {
      this.educators = data;
      this.filteredEducators = data;
    });
  }

  ngOnChanges(): void {
    this.filterEducators();
  }

  filterEducators(): void {
    if (this.searchTerm) {
      this.filteredEducators = this.educators.filter(educator =>
        educator.name.toLowerCase().includes(this.searchTerm.toLowerCase()));
    } else {
      this.filteredEducators = this.educators;
    }
  }

  goToDetail(name: string): void {
    this.router.navigate(['/detail', name]);
  }

}
