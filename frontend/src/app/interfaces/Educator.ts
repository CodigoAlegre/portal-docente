export interface Educator {
    id: number;
    name: string;
    area: string;
    personalDescription?: string;
    email?: string;
    location?: string;
    profilePic?: string;
    optionalPics?: string[];
    bio?: string;
    certifications?: string[];
    experience?: string[];
    oficialTitles?: string[];
    articles?: {
      articleName: string;
      articlePicture: string;
      articleDescription: string;
      articleLink: string;
    }[];
    communityMessages?: {
      messageAutor: string;
      messageRelationship: string;
      messageContent: string;
    }[];
  }