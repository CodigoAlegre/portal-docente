import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { Educator } from '../interfaces/Educator';

@Injectable({
  providedIn: 'root'
})
export class EducatorsService {

  
  private apiUrl = 'https://educadores.educacionenaccion.site/databaseconnect.php';  

  constructor(private http: HttpClient) { }

  getEducatorsList(): Observable<Educator[]> {
    return this.http.get<Educator[]>(this.apiUrl)
    .pipe(
      catchError(this.handleError('getEducatorsList', [
        { id: 1, name: 'John Doe', area: 'Educación Física'},
        { id: 2, name: 'Jane Doe', area: 'Matemáticas'},
        { id: 3, name: 'Richard Roe', area: 'Informática'}
      ]))
    );
  }

  getEducatorByName(name: string): Observable<Educator>{
    return this.http.get<Educator>(`${this.apiUrl}?name=${name}`)
    .pipe(
      catchError(this.handleError('getEducatorByName', { 
        id: 1,
        name: 'John Doe',
        area: 'Educación Física',
        personalDescription: 'John es un educador experimentado en educación física con más de 10 años de experiencia.',
        email: 'john.doe@example.com',
        location: 'Madrid, España',
        profilePic: 'https://avatars.githubusercontent.com/u/69772530?v=4',
        optionalPics: ['https://avatars.githubusercontent.com/u/69772530?v=4', 'https://media.licdn.com/dms/image/D4D03AQG0wdBc5NFGAA/profile-displayphoto-shrink_400_400/0/1674527155823?e=1724889600&v=beta&t=EGTz4QusKtF6V854iWENqWyv7X3dFeDC4AVZXx23TVU'],
        bio: 'John ha trabajado en varias instituciones educativas y ha desarrollado programas innovadores para la enseñanza de la educación física.',
        certifications: ['Certificado en Entrenamiento Personal', 'Certificado en Nutrición Deportiva'],
        experience: ['Profesor de Educación Física en el Colegio ABC (2010-2015)', 'Entrenador Personal en Gimnasio XYZ (2015-presente)'],
        oficialTitles: ['Licenciatura en Ciencias del Deporte', 'Máster en Educación Física'],
        articles: [
          {
            articleName: 'Innovaciones en la Educación Física',
            articlePicture: 'assets/article1.png',
            articleDescription: 'Un artículo sobre las últimas innovaciones en el campo de la educación física.',
            articleLink: 'https://avatars.githubusercontent.com/u/69772530?v=4'
          },
          {
            articleName: 'Nutrición y Deporte',
            articlePicture: 'assets/article2.png',
            articleDescription: 'Un artículo sobre la importancia de la nutrición en el rendimiento deportivo.',
            articleLink: 'https://avatars.githubusercontent.com/u/69772530?v=4'
          }
        ],
        communityMessages: [
          {
            messageAutor: 'Jane Doe',
            messageRelationship: 'Colega',
            messageContent: 'John es un profesional dedicado y siempre dispuesto a ayudar a sus colegas.'
          },
          {
            messageAutor: 'Richard Roe',
            messageRelationship: 'Alumno',
            messageContent: 'Gracias a John, he mejorado significativamente mi rendimiento físico y mi salud.'
          }
        ]
      }))
      );
  }

  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.error(`${operation} failed: ${error.message}`);
      return of(result as T);
    };
  }
}
