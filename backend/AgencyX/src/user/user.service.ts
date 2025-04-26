// src/user/user.service.ts
import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { User } from './user.entity';
import * as bcrypt from 'bcrypt';

@Injectable()
export class UserService {
  constructor(
    @InjectRepository(User)
    private readonly userRepository: Repository<User>,
  ) {}

  async findOneByEmail(email: string): Promise<User | undefined> {
    return this.userRepository.findOne({ where: { email } });
  }

  async create(email: string, password: string): Promise<User> {
    const hashedPassword = await bcrypt.hash(password, 10);
    const user = this.userRepository.create({ email, password: hashedPassword });
    return this.userRepository.save(user);
  }

  async onModuleInit() {
    const sampleEmail = 'test@example.com';
    const samplePassword = 'Test@123';

    const user = await this.findOneByEmail(sampleEmail);
    if (!user) {
      await this.create(sampleEmail, samplePassword);
      console.log(`Sample user created with email: ${sampleEmail}`);
    } else {
      console.log(`Sample user already exists with email: ${sampleEmail}`);
    }
  }
}
